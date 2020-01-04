import Swal from "sweetalert2";
<template>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ form.editable ? 'Edit' : 'Add' }} Post</h3>
            </div>
            <div class="card-body">
                <div class="box box-primary">
                    <!-- form start -->
                    <form role="form" @submit.prevent="savePost">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Post Title</label>
                                <input id="title" type="text" class="form-control" v-model="form.title"
                                       name="title" placeholder="Enter Post Title"
                                       :class="{ 'is-invalid': form.errors.has('title') }">
                                <has-error :form="form" field="title"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="description">Post Description</label>
                                <markdown-editor v-model="form.description"
                                                 name="description"
                                                 id="description"
                                                 :class="{ 'is-invalid': form.errors.has('description') }"></markdown-editor>
                                <has-error :form="form" field="description"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select v-model="form.category_id" name="category_id" id="category_id" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('category_id') }">
                                    <option disabled selected>Select Category</option>
                                    <option v-for="category in getCategories" :value="category.id"> {{ category.name }} </option>
                                </select>
                                <has-error :form="form" field="category_id"></has-error>
                            </div>
                            <div class="form-group">
                                <input accept="image/*" @change="filePreview($event)" type="file" name="photo" :class="{ 'is-invalid': form.errors.has('photo') }">
                                <img :src="form.photo" alt="" width="80" height="80">
                                <has-error :form="form" field="photo"></has-error>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"> {{ form.editable ? 'Update' : 'Save' }}</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.card-body -->
        </div>
    </section>
</template>

<script>
    export default {
        name: "PostAddEditComponent",
        mounted() {
            this.$store.dispatch("allCategories")
            /*if (this.$route.params.id) {
                axios.get(`/categories/${this.$route.params.id}/edit`)
                    .then((res) => {
                        this.form.fill(res.data.category)
                        this.form.editable = true;
                    })
                    .catch()
            }*/
        },
        computed: {
            getCategories() {
                return this.$store.getters.getCategories;
            }
        },
        data () {
            return {
                form: new Form({
                    id: '',
                    title: '',
                    description: '',
                    category_id: '',
                    photo: '',
                    editable: false
                })
            }
        },

        methods: {
            filePreview(event) {
                var file = event.target.files[0];
                if(file.size > 1048576) {
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'File too large..!'
                    })
                } else {
                    var reader = new FileReader();
                    reader.onload = event => {
                        this.form.photo = event.target.result;
                    };

                    reader.readAsDataURL(file);
                }
            },
            savePost() {
                if(this.form.editable) {
                    this.form.put(`/categories/${this.$route.params.id}`)
                        .then(({ data }) => {
                            toast.fire({
                                icon: data.type,
                                title: data.message
                            })
                            this.$router.push('/posts')
                        })
                        .catch( ({ error }) => { console.log(error) } )
                }
                else {
                    this.form.post('/posts')
                        .then(({ data }) => {
                            toast.fire({
                                icon: data.type,
                                title: data.message
                            })
                            this.$router.push('/posts')
                        })
                        .catch( ({ error }) => { console.log(error) } )
                }
            }
        }
    }
</script>

<style scoped>

</style>
