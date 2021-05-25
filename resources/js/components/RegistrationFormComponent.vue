<template>
    <div class="col-md-4 offset-md-4">
        <div class="bg-white shadow rounded-lg p-4">
            <h1 class="font-weight-bold text-center">
                Co-WIN slot Notifier
            </h1>
            <p class="font-weight-bold text-center" style="margin-top: 6px;">
                Search for Vaccination Slots
            </p>
            <p class="font-weight-normal text-center">
                We do not share the data with third party agencies or use the
                data for any method of advertising or targeting.
            </p>

            <div
                class="alert alert-success alert-dismissible fade show"
                v-show="success"
                role="alert"
            >
                <strong
                    >Registration success - Now you will receive notification
                    when slot becomes available</strong
                >
                <button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="form-group">
                <label for="select_number"
                    >Your Mobile Number (Without +91)</label
                >
                <input
                    required
                    v-model="select_number"
                    type="text"
                    name="select_number"
                    placeholder="Your Mobile Number"
                    class="form-control"
                    id="select_number"
                    aria-describedby="emailHelp"
                />
                <small
                    id="emailHelp"
                    v-if="errors && errors.number"
                    class="form-text text-danger"
                    >{{ errors.number[0] }}</small
                >
            </div>

            <div class="form-group">
                <label for="select_email">Email address</label>
                <input
                    required
                    type="email"
                    v-model="select_email"
                    placeholder="Your Email"
                    class="form-control"
                    id="select_email"
                    aria-describedby="emailHelp"
                />
                <small
                    class="form-text text-danger"
                    v-if="errors && errors.email"
                    >{{ errors.email[0] }}</small
                >
            </div>

            <div class="form-group">
                <label for="select_state">Select Your State</label>
                <select
                    required
                    v-model="select_state"
                    name="select_state"
                    class="form-control"
                    id="select_state"
                    @change="getDistrict()"
                >
                    <option disabled value="">Select Your State</option>
                    <option
                        v-bind:value="state.state_id"
                        :key="state.state_id"
                        v-for="state in states"
                        >{{ state.state_name }}</option
                    >
                </select>
                <small
                    class="form-text text-danger"
                    v-if="errors && errors.state"
                    >{{ errors.state[0] }}</small
                >
            </div>

            <div class="form-group">
                <label for="select_district">Select Your district</label>
                <select
                    required
                    v-model="select_district"
                    name="select_district"
                    class="form-control"
                    id="select_district"
                    @change="getDistrict()"
                >
                    <option disabled value="">Select Your District</option>
                    <option
                        v-for="district in districts"
                        v-bind:value="district.district_id"
                        :key="district.district_id"
                        >{{ district.district_name }}</option
                    >
                </select>
                <small
                    class="form-text text-danger"
                    v-if="errors && errors.district"
                    >{{ errors.district[0] }}</small
                >
            </div>

            <div class="form-group align-middle">
                <p
                    style="
                        display: block;
                        margin-bottom: 0.5rem;
                    "
                >
                    Select Your Age Group:
                </p>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="age1"
                        name="age"
                        value="18"
                        v-model="select_age"
                    />
                    <label class="form-check-label" for="age1">18 - 44</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="age2"
                        name="age"
                        value="45"
                        v-model="select_age"
                    />
                    <label class="form-check-label" for="age2">45+</label>
                </div>
                <small
                    class="form-text text-danger"
                    v-if="errors && errors.age_group"
                    >{{ errors.age_group[0] }}</small
                >
            </div>

            <div class="form-group">
                <button
                    type="button"
                    @click.prevent="saveDetails()"
                    class="btn btn-lg btn-success btn-block"
                >
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "pink-alert",
    data() {
        return {
            states: "",
            state: "",
            accessToken: "3sjOr2rmM52GzhpMHjDEE1kpQeRxwFDr4YcBEimi",
            select_state: "",
            id: "",
            select_district: "",
            select_email: "",
            districts: "",
            select_number: "",
            success: false,
            errors: null,
            msg: "",
            select_age: ""
        };
    },
    created: function() {
        this.getStates();
    },
    methods: {
        closeAlert: function() {
            this.success = false;
        },
        getStates: function() {
            axios.defaults.headers.common["Authorization"] =
                "3sjOr2rmM52GzhpMHjDEE1kpQeRxwFDr4YcBEimi";
            axios
                .get("https://cdn-api.co-vin.in/api/v2/admin/location/states", {
                    headers: {
                        Authorization: "Bearer " + this.accessToken
                    }
                })
                .then(
                    function(response) {
                        this.states = response.data.states;
                        // console.log(this.states);
                    }.bind(this)
                );
        },
        getDistrict: function() {
            // axios.defaults.headers.common["Authorization"] =
            //     "3sjOr2rmM52GzhpMHjDEE1kpQeRxwFDr4YcBEimi";
            this.id = this.select_state;
            axios
                .get(
                    "https://cdn-api.co-vin.in/api/v2/admin/location/districts/" +
                        this.id,
                    {
                        headers: {
                            Authorization: "Bearer " + this.accessToken
                        }
                    }
                )
                .then(
                    function(response) {
                        this.districts = response.data.districts;
                        // console.log(this.districts);
                    }.bind(this)
                );
        },
        saveDetails: function() {
            axios
                .post("/saveDetails", {
                    number: this.select_number,
                    state: this.select_state,
                    district: this.select_district,
                    email: this.select_email,
                    age_group: this.select_age
                })
                .then(
                    function(response) {
                        if (response.data) {
                            // console.log(response.data);
                            // this.msg = response.data;
                            this.success = true;
                            this.errors = null;
                            this.select_state = "";
                            this.select_number = "";
                            this.select_district = "";
                            this.select_email = "";
                            this.select_age = "";
                        } else {
                            // console.log("No Data");
                        }
                    }.bind(this)
                )
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        // console.log(this.errors);
                    }
                    // this.errors = error.response.data.errors;
                });
        }
    }
};
</script>
