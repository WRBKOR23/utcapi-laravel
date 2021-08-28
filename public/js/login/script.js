function logout()
{
    if (localStorage.getItem('a_t') !== null)
    {
        localStorage.removeItem('a_t')
    }
}

logout()
