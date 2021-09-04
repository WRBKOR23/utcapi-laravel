import {postData, fetchData} from '../shared_functions.js'
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
    if (fileUpload.files.length === 0)
    {
        raiseEmptyFieldError(`Chưa có tệp nào được chọn`)
        return
    }

    let divTag = document.getElementById('file-exception');
    divTag.innerHTML = ''

    let flag = true;
    for (let i = 0; i < fileUpload.files.length; i++)
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

        if (status1 !== 200 && status1 !== 201)
        {
            raiseBackEndError(true, 3)
            return
        }
        let responseAsJson1 = await response1.json()

        if (status1 === 201)
        {
            group = responseAsJson1[0]
            fileNameError = fileNameError.concat(responseAsJson1[1])
        }

        if (status1 === 200)
        {
            group = responseAsJson1[0]
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

            if (response.status !== 200)
            {
                flag = false
                break;
            }
        }
    }

    if (!flag)
    {
        raiseBackEndError(1)
        return
    }

    if (fileNameError.length === 0)
    {
        if (flag)
        {
            raiseSuccess('Tải tệp lên thành công!', 'Tiếp tục tải tệp', 'home');
            return;
        }
        raiseBackEndError(1)
    } else
    {
        raiseBackEndError(0)
        displayFileException(fileNameError)
        fileNameError = []
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

function refreshToken(response)
{
    if (response.headers.get('Authorization') !== null)
    {
        let token = response.headers.get('Authorization')
        localStorage.setItem('a_t', token.slice(7))
    }
}
