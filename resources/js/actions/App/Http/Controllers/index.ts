import UserController from './UserController'
import CategoryController from './CategoryController'
import ProductController from './ProductController'
import Settings from './Settings'
const Controllers = {
    UserController: Object.assign(UserController, UserController),
CategoryController: Object.assign(CategoryController, CategoryController),
ProductController: Object.assign(ProductController, ProductController),
Settings: Object.assign(Settings, Settings),
}

export default Controllers