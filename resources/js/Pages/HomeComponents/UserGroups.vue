<script>
import { router } from '@inertiajs/vue3';
import AssigningTaskLIst from './AssigningTaskLIst.vue';
import { formatDistanceToNow, format, parseISO } from 'date-fns';

export default {
    props: ['taskAssigningData', 'groups'],
    tasksAssigning: Array,
    data() {
        return {
        }
    },
    components: {
        AssigningTaskLIst,
    },
    methods: {
        displayData() {
            this.tasksAssigning = JSON.parse(JSON.stringify(this.taskAssigningData))
        },
        openOverlay() {
            this.$emit("openOverlay")
        },
        viewTheGroup(id) {
            router.visit("/group/view/" + id)
        }
        , convertTimestampToReadableTime(timestamp) {
            const currentDate = new Date();
            const parsedTimestamp = parseISO(timestamp);

            // Check if the date is today
            if (currentDate.getDate() === parsedTimestamp.getDate()) {
                return format(parsedTimestamp, "h:mm a");
            }

            // Check if the date is yesterday
            if (currentDate.getDate() - 1 === parsedTimestamp.getDate()) {
                return "Yesterday";
            }

            // Check if the date is within the last week
            if (formatDistanceToNow(parsedTimestamp) < 7) {
                return format(parsedTimestamp, "eeee");
            }

            // If none of the above, display the full date
            return format(parsedTimestamp, "MM/dd/yyyy");
        }

    },
    created() {
        this.displayData()
    }, mounted() {
    }
}
</script>


<template>
    <div class="left-main">
        <div class="user-groups">
            <div class="groups-holder">
                <div class="group-header">
                    <p>Groups</p>
                    <div @click="openOverlay"><i class='bx bx-plus'></i></div>
                </div>
                <div class="groups-items">
                    <div class="group-item" @click="viewTheGroup(item.id)" v-for="(item, index) in groups" :key="index"
                        v-if="groups.length > 0">
                        <img :src="item.group_icon" alt="group logo">
                        <div class="group_name">
                            <p> {{ item.group_name }}</p>
                            <small>Larem</small>
                        </div>
                        <div class="group_time">
                            <!-- <div class="notification_dot">1000</div> -->
                            <small>{{ convertTimestampToReadableTime(item.created_at) }}</small>
                        </div>
                    </div>
                    <div v-else class="no_groups">
                        You are not in any group yet! Click on the "+" button to add yourself into a new one.
                    </div>
                </div>
            </div>
        </div>
        <AssigningTaskLIst :tasksAssigning="tasksAssigning" />
    </div>
</template>
<style>
.groups-items {
    position: relative;
}

.group-item {
    display: flex;
    width: 100%;
    gap: 5px;
    align-items: center;
    justify-content: space-around;
}

.group-item>img {
    height: 45px;
    width: 45px;
    border-radius: 50%;
}

.group_name {
    max-width: 450px;
    width: 90%;
    height: 55px;
    text-overflow: ellipsis;
    overflow: hidden;
    text-wrap: nowrap;
}

.group_name>small {
    color: #413d3d;
    text-overflow: ellipsis;
    overflow: hidden;
    text-wrap: nowrap;
}

.group_time {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 55px;
}

.group_time>small {
    font-size: 10px !important;
}

.notification_dot {
    /* width: 16px;
    height: 16px; */
    background: var(--orange);
    font-size: 9px;
    display: grid;
    place-items: center;
    color: var(--white);
    border-radius: 10px;
}

.no_groups {
    position: absolute;
    left: 50%;
    right: 50%;
    transform: translate(-50%, -50%);
    color: var(--white);
    width: 100%;
    text-align: center;
    font-size: 1.3rem;
    margin-top: 4rem;

}
</style>
