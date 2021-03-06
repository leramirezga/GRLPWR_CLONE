<template>
    <div :class="unread_notifications.length != 0 ? 'dropdown d-inline-block badge1' : 'dropdown d-inline-block'" :data-badge="unread_notifications.length">
        <img class="banner-icon" alt="notificaciones" src="images/notifications.png" id="dropdownMenuButton2" data-toggle="dropdown">

        <div class="dropdown-menu dropdown-menu-right floating-card bg-dark notification" aria-labelledby="navbarDropdown" style="text-align: left; padding: 3vh">
            <p v-if="notifications.length == 0 && unread_notifications.length == 0">
                No tienes notificaciones
            </p>
            <p style="margin-bottom: 2vh;" v-if="unread_notifications.length != 0">Nuevas</p>
            <a v-for="unread_notification in unread_notifications" class="dropdown-item break-word notification-item floating-card"   v-on:click="MarkAsRead(unread_notification)" :href="unread_notification.data.link">
                <p style="margin: 0">{{unread_notification.data.mensaje}}</p>
            </a>
            <p style="margin: 2vh 0;" v-if="notifications.length != 0">Antiguas</p>
            <a v-for="notification in notifications" class="dropdown-item break-word notification-item floating-card"  :href="notification.data.link">
                <p style="margin: 0">{{notification.data.mensaje}}</p>
            </a>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: ['notifications','unread_notifications'],
        methods:{
            MarkAsRead: function (notification) {
                var data = {
                    id: notification.id
                };
                axios.post('/notification/read', data).then(response => {
                    //Otra forma de navegar es descomentando el siguiente código: (dejando href=# en el link)
                    // window.location.href = "/ofertar/"+notification.data.solicitud.id;
                });
            }
        }
    }
</script>
