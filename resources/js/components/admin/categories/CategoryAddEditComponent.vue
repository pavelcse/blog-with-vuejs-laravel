<template>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Post Component</h3>
            </div>
            <div class="card-body">
                <div class="box box-primary">
                    <!-- form start -->
                    <form role="form" @submit.prevent="addCategory">
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
                            <button type="submit" class="btn btn-primary">Submit</button>
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
        data () {
            return {
                form: new Form({
                    name: '',
                    is_published: ''
                })
            }
        },

        methods: {
            addCategory() {
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
</script>

<style scoped>

</style>
