<template>
    <div>
        <a class="btn btn-primary mb-2" href="/export">Export as CSV</a>
        <!-- <button
            type="button"
            class="btn btn-primary mb-2"
            @click.prevent="exportDetails()"
        >
            Export as CSV
        </button> -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Number</th>
                    <th scope="col">Email</th>
                    <th scope="col">State</th>
                    <th scope="col">District</th>
                    <th scope="col">Age Group</th>
                </tr>
            </thead>
            <tbody>
                <tr v-bind:value="user.id" :key="user.id" v-for="user in users">
                    <th scope="row">1</th>
                    <td>{{ user.number }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.state }}</td>
                    <td>{{ user.district }}</td>
                    <td>{{ user.age_group }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    data() {
        return {
            users: ""
        };
    },
    created: function() {
        this.getUserList();
    },
    methods: {
        getUserList: function() {
            axios.get("/getUserList").then(
                function(response) {
                    this.users = response.data;
                    console.log(response.data);
                }.bind(this)
            );
        },
        exportDetails: function() {
            axios.get("/export").then(
                function(response) {
                    // this.users = response.data;
                    console.log(response.data);
                }.bind(this)
            );
        }
    }
};
</script>
