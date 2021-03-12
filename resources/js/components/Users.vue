<template>
    <div class="row container m-auto">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header">
                    <h3 class="card-title">Users Table</h3>

                    <div class="card-tools">
                        <div
                            class="input-group input-group-sm"
                            style="width: 150px;"
                        >
                            <div class="input-group-append">
                                <a
                                    href
                                    class="btn btn-primary px-4 py-2"
                                    data-toggle="modal"
                                    data-target="#userModal"
                                    >Add User</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Registered At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.type | upText }}</td>
                                <td>{{ user.created_at | myDate }}</td>
                                <td>
                                    <a href class="badge bg-success p-2"
                                        >Edit</a
                                    >
                                    <a href class="badge bg-danger p-2"
                                        >Delete</a
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <!-- add user modal -->
        <div
            class="modal fade"
            id="userModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="userModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Modal title
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- name -->
                        <div class="form-group">
                            <input
                                placeholder="Name"
                                v-model="form.name"
                                type="text"
                                name="name"
                                class="form-control"
                                :class="{
                                    'is-invalid': form.errors.has('name')
                                }"
                            />
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <!-- email -->
                        <div class="form-group">
                            <input
                                placeholder="Email"
                                v-model="form.email"
                                type="email"
                                name="email"
                                class="form-control"
                                :class="{
                                    'is-invalid': form.errors.has('email')
                                }"
                            />
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <!-- bio -->
                        <div class="form-group">
                            <!-- <input
                                    placeholder="Name"
                                    v-model="form.name"
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('name')
                                    }"
              />-->
                            <textarea
                                v-model="form.bio"
                                class="form-control"
                                :class="{
                                    'is-invalid': form.errors.has('bio')
                                }"
                                name="bio"
                                cols="30"
                                rows="3"
                                placeholder="Short Bio for User(Optional)"
                            ></textarea>
                            <has-error :form="form" field="bio"></has-error>
                        </div>
                        <!-- type -->
                        <div class="form-group">
                            <select
                                v-model="form.type"
                                class="form-control"
                                name="type"
                                id
                                :class="{
                                    'is-invalid': form.errors.has('type')
                                }"
                            >
                                <option value>-- Select Type --</option>
                                <option value="admin">Admin</option>
                                <option value="customer">Customer</option>
                                <option value="author">Author</option>

                                <!-- <option>Admin</option>
                <option>Customer</option>
                <option>Author</option>-->
                            </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>
                        <!-- password -->
                        <div class="form-group">
                            <input
                                placeholder="Password"
                                v-model="form.password"
                                type="password"
                                name="password"
                                class="form-control"
                                :class="{
                                    'is-invalid': form.errors.has('password')
                                }"
                            />
                            <has-error
                                :form="form"
                                field="password"
                            ></has-error>
                        </div>
                    </div>
                    <form @submit.prevent="createUser">
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /. add user modal -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            users: {},
            form: new Form({
                name: "",
                email: "",
                password: "",
                type: "",
                bio: "",
                photo: ""
            })
        };
    },
    methods: {
        loadUsers() {
            axios.get("api/users").then(({ data }) => (this.users = data.data));
        },
        createUser() {
            this.$Progress.start();
            this.form.post("api/users");
            this.$Progress.finish();
        }
    },
    created() {
        this.loadUsers();
    }
    //   mounted() {
    //     console.log("Component mounted.");
    //   }
};
</script>
