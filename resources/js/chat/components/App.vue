<template lang="">
        <div v-if="auth && auth.id !== undefined">
        <h2>Select any user to chat with</h2>
        <ul class="mt-3 mx-3 list-none inline-block">
            <li v-for="user in users" v-bind:key="user.id" class="mb-4 inline">
                <i class="fas fa-comment text-teal-700 px-2"></i>
                <a href="#" class="text-teal-700 hover:text-teal-900 underline" v-on:click.prevent="handleUserClick(user)">{{user.name}}</a>
                <span class="bg-red-500 text-white rounded-full px-2 absolute chat-badge-counter" v-if="user.unseen_messages.length > 0">
                    {{ user.unseen_messages.length }}
                </span>
            </li>
        </ul>
    </div>
    <div v-else>
        <p><a href="/login" class="text-teal-700 hover:text-teal-900 underline capitalize">Login to chat>>>></a></p>
    </div>
</template>
<script>
import { provide, ref } from "vue"
export default {
    name: "App",
    props: ["auth"],
    setup(auth) {
        provide('auth', auth)
        const onlineUsers = ref([]);

        async function getOnlineUsers() {
            const result = await window.axios.get("/online-users");

            if(result.data.users) {
                onlineUsers.value = result.data.users;
            }
        }

        getOnlineUsers();


    }
};
</script>
<style lang=""></style>
