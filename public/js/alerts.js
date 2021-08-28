import {postData} from './shared_functions.js'

export function raiseSuccess (title, okMessage, linkHome)
{
    alertify.confirm(title)
        .setHeader('<i class="fas fa-info-circle"></i> Thông tin')
        .setting({
            'labels':
                {
                    ok: okMessage,
                    cancel: 'Về trang chủ'
                },
            'defaultFocusOff': true,
            'maximizable': false,
            'movable': false,
            'pinnable': false,
            'onok': () => window.location.reload(),
            'oncancel': () => window.location.replace((linkHome))
        })
}

export function raiseEmptyFieldError (error)
{
    alertify.error(error)
        .delay(3)
        .dismissOthers()
}

export function raiseBackEndError (code)
{
    let error;
    let ttl;
    if (code)
    {
        error = 'Có lỗi đã xảy ra, hãy thử lại sau!'
        ttl = 3
    }
    else
    {
        error = 'Có ngoại lệ xảy ra trong quá trình nhập dữ liệu. ' +
            'Chi tiết ngoại lệ của mỗi file tải lên sẽ được ghi rõ trong các file hiển thị ở web với tên file tương ứng'
        ttl = 7
    }
    alertify.error(error)
        .delay(ttl)
        .dismissOthers()
}

export async function postDataAndRaiseAlert (url, data, invalidFieldFunc, okMessage, linkHome)
{
    let invalidField = invalidFieldFunc(data)

    if (invalidField !== null)
    {
        raiseEmptyFieldError(invalidField)
        return false
    }

    const response = await postData(url, data)
    if (response.status === 200)
    {
        raiseSuccess(okMessage, linkHome)
    }
    else
    {
        raiseBackEndError()
    }

    return true
}
