<script>
import { formatDistanceToNow, format, parseISO } from 'date-fns';

export default {
    props: ['assigningTasks'],
    data() {
        return {
            useSubmitTask: this.assigningTasks.map((item) => item.completed == 1)
        }
    },
    mounted() {
    }, methods: {
        convertTimestampToReadableTime(timestamp) {
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
        },
        getStatus(timestamp) {
            let currentDate = new Date();
            let dueDate = parseISO(timestamp);

            if (dueDate) {
                if (currentDate > dueDate) {
                    return "Late"
                } else {
                    return "Pending"
                }
            } else {
                return "null"
            }
        }

    }
}
</script>

<template>
    <div class="created-tasks-holder">
        <div class="side-display">
            <h2>Pending Latest Tasks Created</h2>
            <div class="display-container" v-if="assigningTasks.length > 0">
                <div v-for="(item, index) in assigningTasks" :key="index" class="display-item">
                    <p>{{ item.name.toUpperCase() }} </p>
                    <span>Status: <p>{{ getStatus(item.due_date) }}</p></span>
                    <small>{{ convertTimestampToReadableTime(item.created_at) }}</small>
                </div>

            </div>
            <div class="no-data" v-else>
                <p>No Data Yet.</p>
            </div>
        </div>
        <div class="side-display">
            <h2>Latest User Submit</h2>
            <div class="display-container" v-if="useSubmitTask.length > 0">
                <div class="display-item" v-for="(item, index) in useSubmitTask" :key="index">
                    <p>{{ item.name.toUpperCase() }} </p>
                    <span>Status: <p>{{ getStatus(item.due_date) }}</p></span>
                    <small>{{ convertTimestampToReadableTime(item.created_at) }}</small>
                </div>
            </div>
            <div class="no-data" v-else>
                <p>No Data Yet.</p>
            </div>
        </div>
    </div>
</template>