//  Get data from database
export async function fetchData (url)
{
    const init = {
        method: 'GET',
        cache: 'no-cache',
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('a_t')
        }
    }

    let response = await fetch(url, init)
    refreshToken(response)

    let responseJson
    if (response.status === 200)
    {
        responseJson = await response.json()
    }
    else
    {
        responseJson = null
    }

    return responseJson
}

export async function postData (url, data)
{
    const init = {
        method: 'POST',
        cache: 'no-cache',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('a_t'),
        },
        body: JSON.stringify(data)
    }
    let response = await fetch(url, init)
    refreshToken(response)

    return response
}

function refreshToken (response)
{
    if (response.headers.get('Authorization') !== null)
    {
        let token = response.headers.get('Authorization')
        localStorage.setItem('a_t', token.slice(7))
    }
}
