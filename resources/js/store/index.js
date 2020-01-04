export default {
    state: {
        categories: [],
        posts: [],
    },
    getters: {
        getCategories(state) {
            return state.categories
        },
        getPosts(state) {
            return state.posts
        }
    },
    mutations: {
        categories (state, data) {
            return state.categories = data;
        },
        posts (state, data) {
            return state.posts = data;
        }
    },
    actions: {
        allCategories(context) {
            axios.get('/categories')
                .then((res) => {
                    context.commit('categories', res.data.categories)
                })
        },
        allPosts(context) {
            axios.get('/posts')
                .then((res) => {
                    context.commit('posts', res.data.posts)
                })
        }
    }
}
