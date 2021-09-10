import {raiseBackEndError, raiseEmptyFieldError, raiseSuccess} from '../alerts.js'

let fileNameError = []
let group = [];
document.addEventListener('DOMContentLoaded', async () =>
{
    document.getElementById('submit_btn').addEventListener('click', uploadFile)
    document.getElementById('fileUpload').addEventListener('change', listFileName)
})

/*--------------------------------------*/

async function uploadFile ()
{
    let fileLength = fileUpload.files.length
    if (fileLength === 0)
    {
        raiseEmptyFieldError(`Chưa có tệp nào được chọn`)
        return
    }

    reset()

    for (let i = 0; i < fileLength; i++)
    {
        let formData = new FormData();
        formData.append('file', fileUpload.files[i]);

        let response1 = await fetch('web/import-data/process-1', {
            method: 'POST',
            cache: 'no-cache',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('a_t')
            },
            body: formData
        });
        refreshToken(response1)

        let status1 = response1.status

        if (status1 === 500)
        {
            raiseBackEndError(true, 3)
            return
        }

        if (status1 === 406)
        {
            let fileName = fileUpload.files[i].name
            fileNameError.push(fileName.substr(0, fileName.lastIndexOf('.')) + '.txt')
        }

        if (status1 === 200)
        {
            group = await response1.json()
        }

        for (const arr of group)
        {
            let response = await fetch('web/import-data/process-2', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('a_t')
                },
                body: JSON.stringify(arr)
            });
            refreshToken(response)

            if (response.status === 500)
            {
                raiseBackEndError(true, 3)
                return
            }
        }
    }

    if (fileNameError.length === 0)
    {
        raiseSuccess('Tải tệp lên thành công!', 'Tiếp tục tải tệp', 'home');
    }
    else
    {
        raiseBackEndError(0)
        displayFileException(fileNameError)
    }
}

function listFileName ()
{
    let divTag = document.querySelector('#file-list')
    divTag.innerHTML = ''

    let innerHtml = ''
    for (let i = 0; i < fileUpload.files.length; i++)
    {
        innerHtml += '<span>' + fileUpload.files[i].name + '</span><br>'
    }

    divTag.innerHTML = innerHtml
}

function reset ()
{
    let divTag = document.getElementById('file-exception');
    divTag.innerHTML = ''
    fileNameError = []
}

function displayFileException ()
{
    let divTag = document.getElementById('file-exception');

    for (const fileName of fileNameError)
    {
        {
            let aTag = document.createElement('a')
            aTag.innerHTML = fileName
            aTag.href = '../storage/app/public/excels/errors/' + fileName;
            aTag.setAttribute('download', '');

            let brTag = document.createElement('br')

            divTag.append(aTag)
            divTag.append(brTag)
        }
    }
}

function refreshToken (response)
{
    if (response.headers.get('Authorization') !== null)
    {
        let token = response.headers.get('Authorization')
        localStorage.setItem('a_t', token.slice(7))
    }
}
