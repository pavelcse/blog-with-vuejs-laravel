import AdminHome from "./components/admin/AdminHome";
import AdminPost from "./components/admin/AdminPost";
import CategoryListComponent from "./components/admin/categories/CategoryListComponent";
import CategoryAddEditComponent from "./components/admin/categories/CategoryAddEditComponent";

export const routes = [
    {
        path: '/home', component: AdminHome
    },
    {
        path: '/post', component: AdminPost
    },
    {
        path: '/categories', component: CategoryListComponent
    },
    {
        path: '/category-add', component: CategoryAddEditComponent
    }
]
