
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import axios from 'axios'
import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'b47762f87836b9d19877',
    cluster: 'mt1',
    encrypted: true,
});

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('notification', require('./components/Notification.vue'));


const app = new Vue({
    el: '#app',
    data:{
        notifications: '',
        unread_notifications: [],
    },
    mounted(){

    },
    created(){
        axios.post('/notification/get').then(response => {
            this.notifications = response.data;
            for (var i=0; i < this.notifications.length; i++){
                if(this.notifications[i].read_at == null){
                    this.unread_notifications.push(this.notifications[i]);
                    this.notifications.splice(i,1);
                    i--;
                }
            }

        });
        var userId = $('meta[name="userId"]').attr('content');
        /*window.Echo.channel('chat')
            .listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (notification) => {
                this.notifications.push(notification);
                console.log(notification.data.solicitud.id);
            });*/
        window.Echo.private('App.User.'+userId)
            .notification((notification) => {
                this.unread_notifications.push(notification);
            });
    },
});
