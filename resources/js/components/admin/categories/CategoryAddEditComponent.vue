<template>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ form.editable ? 'Edit' : 'Add' }} Category</h3>
            </div>
            <div class="card-body">
                <div class="box box-primary">
                    <!-- form start -->
                    <form role="form" @submit.prevent="saveCategory">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Category Name</label>
                                <input type="text" class="form-control" v-model="form.name"
                                       name="name" id="name" placeholder="Enter Category Name"
                                       :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input v-model="form.is_published" name="is_published"
                                           type="checkbox" value="1"
                                           :class="{ 'is-invalid': form.errors.has('is_published') }"> Published
                                    <has-error :form="form" field="is_published"></has-error>
                                </label>
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
        name: "CategoryAddEditComponent",
        mounted() {
            if (this.$route.params.id) {
                axios.get(`/categories/${this.$route.params.id}/edit`)
                .then((res) => {
                    this.form.fill(res.data.category)
                    this.form.editable = true;
                })
                .catch()
            }
        },
        data () {
            return {
                form: new Form({
                    id: '',
                    name: '',
                    is_published: '',
                    editable: false
                })
            }
        },

        methods: {
            saveCategory() {
                if(this.form.editable) {
                    this.form.put(`/categories/${this.$route.params.id}`)
                        .then(({ data }) => {
                            toast.fire({
                                icon: data.type,
                                title: data.message
                            })
                            this.$router.push('/categories')
                        })
                        .catch( ({ error }) => { console.log(error) } )
                }
                else {
                    this.form.post('/categories')
                        .then(({ data }) => {
                            toast.fire({
                                icon: data.type,
                                title: data.message
                            })
                            this.$router.push('/categories')
                        })
                        .catch( ({ error }) => { console.log(error) } )
                }
            }
        }
    }
</script>

<style scoped>

</style>
