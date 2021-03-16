<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card card-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-info">
            <h3 class="widget-user-username">{{form.name}}</h3>
            <h5 class="widget-user-desc">Type: {{form.type}}</h5>
            <h5 class="widget-user-desc">Bio: {{form.bio}}</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle elevation-2" v-bind:src="userPhoto" alt="User Avatar" />
            <!-- <img class="img-circle elevation-2" :src="getProfilePhoto()" alt="User Avatar" /> -->
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">3,200</h5>
                  <span class="description-text">SALES</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">13,000</h5>
                  <span class="description-text">FOLLOWERS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">35</h5>
                  <span class="description-text">PRODUCTS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="tab-pane active" id="settings">
          <form class="form-horizontal">
            <div class="form-group row">
              <label for="inputName" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Name"
                  v-model="form.name"
                  :class="{
                   'is-invalid': form.errors.has('name')}"
                />
                <has-error :form="form" field="name"></has-error>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input
                  type="email"
                  class="form-control"
                  placeholder="Email"
                  v-model="form.email"
                  :class="{
                   'is-invalid': form.errors.has('email')}"
                />
                <has-error :form="form" field="email"></has-error>
              </div>
            </div>

            <div class="form-group row">
              <label for="inputExperience" class="col-sm-2 col-form-label">Bio</label>
              <div class="col-sm-10">
                <textarea
                  class="form-control"
                  id="inputExperience"
                  placeholder="Bio"
                  v-model="form.bio"
                  :class="{
                   'is-invalid': form.errors.has('bio')}"
                ></textarea>
                <has-error :form="form" field="bio"></has-error>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputExperience" class="col-sm-2 col-form-label">Profile Photo</label>
              <div class="col-sm-10">
                <input
                  type="file"
                  @change="updatePhoto"
                  ref="fileupload"
                  :class="{
                   'is-invalid': form.errors.has('photo')}"
                />
                <has-error :form="form" field="photo"></has-error>
              </div>
            </div>

            <div class="form-group row">
              <label for class="col-sm-2 col-form-label">Password</label>

              <div class="col-sm-10">
                <input
                  type="password"
                  class="form-control"
                  v-model="form.password"
                  placeholder="Password (Leave empty if not changing)"
                  :class="{
                   'is-invalid': form.errors.has('password')}"
                />
                <has-error :form="form" field="password"></has-error>
              </div>
            </div>
            <div class="form-group row">
              <div class="offset-sm-2 col-sm-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" /> I agree to the
                    <a href="#">terms and conditions</a>
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="offset-sm-2 col-sm-10">
                <button type="submit" @click.prevent="updateInfo" class="btn btn-danger">Update</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      userPhoto: "",
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
    getProfilePhoto() {
      let photo =
        this.form.photo.length > 200
          ? this.form.photo
          : "img/profile/" + this.form.photo;
      return photo;
    },
    updatePhoto(e) {
      let file = e.target.files[0];
      let reader = new FileReader();

      if (file["size"] < 2111775) {
        reader.onloadend = file => {
          this.form.photo = reader.result;
          //   console.log(reader.result);
          this.userPhoto = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        this.$refs.fileupload.value = null;
        swal.fire({
          icon: "error",
          title: "Oops...",
          text: "File is greater than 2MB!"
          //   footer: "<a href>Why do I have this issue?</a>"
        });
      }
    },
    updateInfo() {
      //   this.$Progress.start();
      //   this.form
      //     .put("api/profile")
      //     .then(() => {
      //       this.$Progress.finish();
      //     })
      //     .catch(() => {
      //       this.$Progress.fail();
      //     });

      this.$Progress.start();
      this.form
        .put("api/profile")
        .then(() => {
          this.$Progress.finish();
          //Toaster from Sweet Alert
          toast.fire({
            icon: "success",
            title: "Profile Updated successfully"
          });
          Fire.$emit("AfterUpdate");
        })
        .catch(() => {
          this.$Progress.fail();

          //Toaster from Sweet Alert
          toast.fire({
            type: "error",
            title: "Something went wrong!"
          });
        });
    }
  },

  mounted() {
    console.log("Component mounted.");
  },
  created() {
    //axios.get("api/profile").then(({ data }) => this.form.fill(data));
    this.$Progress.start();
    axios
      .get("api/profile")
      .then(({ data }) => {
        this.userPhoto = "img/profile/" + data.photo;
        Fire.$on("AfterUpdate", () => {
          axios.get("api/profile").then(data => {
            let photo = data.data.photo;
            this.userPhoto = "img/profile/" + photo;
          });
        });
        this.form.reset();
        this.form.fill(data);
        this.$Progress.finish();
      })
      .catch(() => {
        this.$Progress.fail();
      });
  }
};
</script>
