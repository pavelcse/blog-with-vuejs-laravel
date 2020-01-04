<template>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Categories</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <router-link class="btn btn-info btn-sm float-right my-2 text-white" to="category-add">Add Category</router-link>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Published</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(category, index) in getCategories">
                                <td> {{ index + 1 }} </td>
                                <td>{{ category.name }}</td>
                                <td>{{ category.is_published ? 'Yes' : 'No' }}</td>
                                <td>{{ category.created_at | timeFormat }}</td>
                                <td>
                                    <a class="btn btn-sm btn-info mx-2 text-white" href="">View</a>
                                    <router-link :to="`/category-edit/${category.id}`" class="btn btn-sm btn-primary mx-2 text-white" href="">Edit</router-link>
                                    <a class="btn btn-sm btn-danger mx-2 text-white" href="" @click.prevent="deleteCategory(category.id)">Delete</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.card-body -->
        </div>
    </section>
</template>

<script>
    export default {
        name: "CategoryListComponent",
        mounted() {
            this.$store.dispatch("allCategories")
        },
        computed: {
            getCategories() {
               return this.$store.getters.getCategories;
            }
        },
        methods: {
            deleteCategory(categoryId) {
                axios.delete('/categories/' + categoryId)
                .then(({ data }) => {
                    this.$store.dispatch("allCategories")
                    toast.fire({
                        icon: data.type,
                        title: data.message
                    })
                })
                .catch(({ data }) => {
                    toast.fire({
                        icon: data.type,
                        title: data.message
                    })
                })
            }
        }
    }
</script>

<style scoped>

</style>
