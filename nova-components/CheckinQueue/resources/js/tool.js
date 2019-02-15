Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'checkin-queue',
            path: '/checkin-queue',
            component: require('./components/Tool'),
        },
    ])
})
