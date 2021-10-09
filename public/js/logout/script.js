import {postData} from '../shared_functions.js'

function logout ()
{
    const data = {}
    const url = 'web/auth/logout'
    postData(url, data)

    window.location.replace('login')
}

logout()
