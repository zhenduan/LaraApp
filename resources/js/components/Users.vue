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
                                    @click="newModal"
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
                                <td>
                                    {{ user.id }}
                                </td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.type | upText }}</td>
                                <td>{{ user.created_at | myDate }}</td>
                                <td>
                                    <a
                                        href
                                        class="badge bg-success p-2"
                                        @click.prevent="editModal(user)"
                                        >Edit</a
                                    >
                                    <a
                                        href
                                        class="badge bg-danger p-2"
                                        @click.prevent="deleteUser(user.id)"
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
                        <h5
                            v-show="!editMode"
                            class="modal-title"
                            id="exampleModalLabel"
                        >
                            Create User
                        </h5>
                        <h5
                            v-show="editMode"
                            class="modal-title"
                            id="exampleModalLabel"
                        >
                            Update User
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
                    <!-- form start here -->
                    <form
                        @submit.prevent="editMode ? updateUser() : createUser()"
                    >
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
                                <has-error
                                    :form="form"
                                    field="name"
                                ></has-error>
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
                                <has-error
                                    :form="form"
                                    field="email"
                                ></has-error>
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
                                <has-error
                                    :form="form"
                                    field="type"
                                ></has-error>
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
                                        'is-invalid': form.errors.has(
                                            'password'
                                        )
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="password"
                                ></has-error>
                            </div>
                        </div>
                        <!-- <form
                        @submit.prevent="editMode ? updateUser() : createUser()"
                    > -->
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button
                                v-show="!editMode"
                                type="submit"
                                class="btn btn-primary"
                            >
                                Create
                            </button>
                            <button
                                v-show="editMode"
                                type="submit"
                                class="btn btn-primary"
                            >
                                Update
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
            editMode: false,
            users: {},
            form: new Form({
                id: "",
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
            this.form
                .post("api/users")
                .then(() => {
                    Fire.$emit("ReloadUsers");
                    toast.fire({
                        icon: "success",
                        title: "User Created successfully"
                    });
                    // close modal
                    $("#userModal").modal("hide");
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },
        updateUser() {
            this.editMode = true;
            this.$Progress.start();
            this.form
                .put("api/users/" + this.form.id)
                .then(() => {
                    //close modal
                    $("#userModal").modal("hide");
                    toast.fire({
                        icon: "success",
                        title: "User Updated successfully"
                    });

                    // reload users
                    Fire.$emit("ReloadUsers");
                    //progress bar finish
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },
        deleteUser(id) {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                if (result.isConfirmed) {
                    // send delete user request
                    this.form
                        .delete("api/users/" + id)
                        .then(() => {
                            swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            Fire.$emit("ReloadUsers");
                        })
                        .catch(() => {});
                }
            });
        },
        newModal() {
            // open modal
            this.editMode = false;
            this.form.clear();
            this.form.reset();
            $("#userModal").modal("show");
        },
        editModal(user) {
            // open modal
            this.form.clear();
            this.form.reset();
            this.editMode = true;

            $("#userModal").modal("show");
            this.form.fill(user);
        }
    },
    created() {
        this.loadUsers();
        Fire.$on("ReloadUsers", () => {
            this.loadUsers();
        });
    }
    //   mounted() {
    //     console.log("Component mounted.");
    //   }
};
</script>
