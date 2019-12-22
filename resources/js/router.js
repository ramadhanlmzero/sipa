import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import index from './components/index.vue'
import login from './components/auth/login.vue'
import account_index from './components/account/index.vue'
import account_edit from './components/account/edit.vue'
import account_reset from './components/account/reset.vue'
import forbidden from './components/auth/403.vue'
import notfound from './components/404.vue'
import dashboard from './components/dashboard.vue'
import role_index from './components/role/index.vue'
import role_create from './components/role/create.vue'
import role_edit from './components/role/edit.vue'
import userrole_index from './components/userrole/index.vue'
import userrole_edit from './components/userrole/edit.vue'
import category_index from './components/category/index.vue'
import category_create from './components/category/create.vue'
import category_edit from './components/category/edit.vue'
import room_index from './components/room/index.vue'
import room_create from './components/room/create.vue'
import room_edit from './components/room/edit.vue'
import rack_index from './components/rack/index.vue'
import rack_create from './components/rack/create.vue'
import rack_edit from './components/rack/edit.vue'
import archive_index from './components/archive/index.vue'
import archive_create from './components/archive/create.vue'
import archive_edit from './components/archive/edit.vue'
import user_index from './components/user/index.vue'
import user_create from './components/user/create.vue'
import user_edit from './components/user/edit.vue'

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/login',
            name: 'login',
            component: login,
            meta: {
                auth: false
            }
        },
        {
            path: '/403',
            name: 'forbidden',
            component: forbidden
        },
        {
            path: '/404',
            name: 'notfound',
            component: notfound
        },
        {
            path: '*',
            component: notfound
            // redirect: '/404'
        },
        {
            path: '/',
            component: index,
            meta: {
                auth: true
            },
            redirect: '/dashboard',
            children: [
                {
                    path: '/dashboard',
                    name: 'dashboard',
                    component: dashboard
                },
                {
                    path: '/account',
                    name: 'account_index',
                    component: account_index
                },
                {
                    path: '/account/edit/:id',
                    name: 'account_edit',
                    component: account_edit
                },
                {
                    path: '/account/reset/:id',
                    name: 'account_reset',
                    component: account_reset
                },
                {
                    path: '/archive',
                    name: 'archive_index',
                    component: archive_index
                },
                {
                    path: '/archive/create',
                    name: 'archive_create',
                    component: archive_create
                },
                {
                    path: '/archive/edit/:id',
                    name: 'archive_edit',
                    component: archive_edit
                },
                {
                    path: '/category',
                    name: 'category_index',
                    component: category_index,
                    meta: {
                        auth: {
                            roles: ['Superadmin', 'Staf Tata Usaha'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/category/create',
                    name: 'category_create',
                    component: category_create,
                    meta: {
                        auth: {
                            roles: ['Superadmin', 'Staf Tata Usaha'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/category/edit/:id',
                    name: 'category_edit',
                    component: category_edit,
                    meta: {
                        auth: {
                            roles: ['Superadmin', 'Staf Tata Usaha'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/room',
                    name: 'room_index',
                    component: room_index,
                    meta: {
                        auth: {
                            roles: ['Superadmin', 'Staf Tata Usaha'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/room/create',
                    name: 'room_create',
                    component: room_create,
                    meta: {
                        auth: {
                            roles: ['Superadmin', 'Staf Tata Usaha'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/room/edit/:id',
                    name: 'room_edit',
                    component: room_edit,
                    meta: {
                        auth: {
                            roles: ['Superadmin', 'Staf Tata Usaha'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/rack',
                    name: 'rack_index',
                    component: rack_index,
                    meta: {
                        auth: {
                            roles: ['Superadmin', 'Staf Tata Usaha'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/rack/create',
                    name: 'rack_create',
                    component: rack_create,
                    meta: {
                        auth: {
                            roles: ['Superadmin', 'Staf Tata Usaha'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/rack/edit/:id',
                    name: 'rack_edit',
                    component: rack_edit,
                    meta: {
                        auth: {
                            roles: ['Superadmin', 'Staf Tata Usaha'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/role',
                    name: 'role_index',
                    component: role_index,
                    meta: {
                        auth: {
                            roles: ['Superadmin'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/role/create',
                    name: 'role_create',
                    component: role_create,
                    meta: {
                        auth: {
                            roles: ['Superadmin'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/role/edit/:id',
                    name: 'role_edit',
                    component: role_edit,
                    meta: {
                        auth: {
                            roles: ['Superadmin'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/user',
                    name: 'user_index',
                    component: user_index,
                    meta: {
                        auth: {
                            roles: ['Superadmin'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/user/create',
                    name: 'user_create',
                    component: user_create,
                    meta: {
                        auth: {
                            roles: ['Superadmin'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/user/edit/:id',
                    name: 'user_edit',
                    component: user_edit,
                    meta: {
                        auth: {
                            roles: ['Superadmin'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/userrole',
                    name: 'userrole_index',
                    component: userrole_index,
                    meta: {
                        auth: {
                            roles: ['Superadmin'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                },
                {
                    path: '/userrole/edit/:id',
                    name: 'userrole_edit',
                    component: userrole_edit,
                    meta: {
                        auth: {
                            roles: ['Superadmin'], redirect: { name: 'login' }, forbiddenRedirect: '/403'
                        }
                    }
                }
            ]
        }
    ]
})

export default router