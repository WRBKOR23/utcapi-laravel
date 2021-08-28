import {postData} from '../shared_functions.js'

async function logout ()
{
    const data = {}
    const url = 'web/auth/logout'
    await postData(url, data)

    window.location.replace('../public/login')
}

logout()
