export default [
    { path: '/v', redirect: '/manufacturers' },

    {
        path: '/manufacturers',
        name: 'manufacturers',
        component: require('./screens/manufacturers/index'),
    },

    {
        path: '/manufacturers/:id/edit',
        name: 'manufacturers.edit',
        component: require('./screens/manufacturers/edit'),
    },

    {
        path: '/manufacturers/create',
        name: 'manufacturers.create',
        component: require('./screens/manufacturers/create'),
    },

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
