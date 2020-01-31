import AdminHome from "./components/admin/AdminHome";
import CategoryListComponent from "./components/admin/categories/CategoryListComponent";
import CategoryAddEditComponent from "./components/admin/categories/CategoryAddEditComponent";
import PostListComponent from './components/admin/posts/PostListComponent'
import PostAddEditComponent from "./components/admin/posts/PostAddEditComponent";

// Front Components
import FrontHomeComponent from "./components/frontend/FrontHomeComponent";

export const routes = [
    {
        path: '/home', component: AdminHome
    },
    {
        path: '/categories', component: CategoryListComponent
    },
    {
        path: '/category-add', component: CategoryAddEditComponent
    },
    {
        path: '/category-edit/:id', component: CategoryAddEditComponent
    },
    {
        path: '/posts', component: PostListComponent
    },
    {
        path: '/post-add', component: PostAddEditComponent
    },
    {
        path: '/post-edit/:id', component: PostAddEditComponent
    },

    {
        path: '/', component: FrontHomeComponent
    },
];
