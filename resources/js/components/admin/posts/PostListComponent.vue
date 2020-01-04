<template>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Posts</h3>

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
                        <router-link class="btn btn-info btn-sm float-right my-2 text-white" to="post-add">Add Post</router-link>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Photo</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Created By</th>
                                <th>Posted</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(post, index) in getPosts">
                                <td> {{ index + 1 }} </td>
                                <td><img style="height: 50px" :src="post.photo" alt=""></td>
                                <td>{{ post.title | shortlen(20, "...") }}</td>
                                <td>{{ post.description | shortlen(40, "...") }}</td>
                                <td v-if="post.category">{{ post.category.name }}</td>
                                <td v-if="post.user">{{ post.user.name }}</td>
                                <td>{{ post.created_at | timeFormat }}</td>
                                <td>
                                    <a class="btn btn-sm btn-info mx-2 text-white" href="">View</a>
                                    <router-link :to="`/post-edit/${post.id}`" class="btn btn-sm btn-primary mx-2 text-white" href="">Edit</router-link>
                                    <a class="btn btn-sm btn-danger mx-2 text-white" href="" @click.prevent="deletePost(post.id)">Delete</a>
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
        name: "PostListComponent",
        mounted() {
            this.$store.dispatch("allPosts")
        },
        computed: {
            getPosts() {
                return this.$store.getters.getPosts;
            }
        },
        methods: {
            deletePost(postId) {
                axios.delete('/posts/' + postId)
                    .then(({ data }) => {
                        this.$store.dispatch("allPosts")
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
