export default [
    { path: '/v', redirect: '/products' },

    {
        path: '/products',
        name: 'products',
        component: require('./screens/products/index'),
    },

    {
        path: '/products/:id/edit',
        name: 'products.edit',
        component: require('./screens/products/edit'),
    },

    {
        path: '/products/create',
        name: 'products.create',
        component: require('./screens/products/create'),
    },
];
