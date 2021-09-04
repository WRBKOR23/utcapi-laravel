import {fetchData, postData} from '../shared_functions.js'
import {raiseBackEndError, raiseEmptyFieldError, raiseSuccess} from '../alerts.js'

let id_sender = $('[name="id_"]').val()
let data
let selectedNoti = []
let num = 0

document.addEventListener('DOMContentLoaded', async () =>
{
    await lazyLoad()
})

let observer = new IntersectionObserver(async function (e)
{
    if (e[0].intersectionRatio === 1)
    {
        let element = document.getElementById('observe')
        observer.unobserve(element)
        element.removeAttribute('id')

        await lazyLoad()
    }
}, {
    threshold: [0, 1]
})

async function lazyLoad ()
{
    data = await fetchData('web/notification/' + id_sender + '/' + num)
    num += 15
    if (data === '')
    {
        return;
    }

    createScrollList()
}

function createScrollList ()
{
    let i = 1
    let selectTag = document.getElementById('noti-select')
    for (const e of data)
    {
        let rowTag = createRow()
        let colTag1 = createColumn('check')
        let colTag2 = createColumn('title')
        let colTag3 = createColumn('content')
        let colTag4 = createColumn('time-create')
        let colTag5 = createColumn('time-start')
        let colTag6 = createColumn('time-end')

        let extractedContent = extractContent(e.content)

        colTag1.append(createCheckBox(e.id_notification))
        colTag2.append(createLabel(e.title, e.id_notification))
        colTag3.append(createLabel(extractedContent[0], e.id_notification))
        colTag4.append(createLabel(formatDate(e.time_create), e.id_notification))
        colTag5.append(createLabel(formatDate(e.time_start), e.id_notification))
        colTag6.append(createLabel(formatDate(e.time_end), e.id_notification))

        if (extractedContent[1] !== '')
        {
            attachLink(colTag3, extractedContent[1])
        }

        rowTag.appendChild(colTag1)
        rowTag.appendChild(colTag2)
        rowTag.appendChild(colTag3)
        rowTag.appendChild(colTag4)
        rowTag.appendChild(colTag5)
        rowTag.appendChild(colTag6)

        selectTag.appendChild(rowTag)

        if (i === 12)
        {
            rowTag.id = 'observe'
            observer.observe(rowTag)
        }
        i++
    }
}

function formatDate (date)
{
    if (date === null)
    {
        return ''
    }
    let arr = date.split(' ')
    let arr2 = arr[0].split('-')
    let arr3 = arr[1].split('.')
    let formatedDate = arr2[2] + '-' + arr2[1] + '-' + arr2[0] + ' ' + arr3[0]

    return formatedDate
}


function createCheckBox (index)
{
    let checkbox = document.createElement('input')
    checkbox.type = 'checkbox'
    checkbox.className = `form-check-input class-checkbox`
    checkbox.id = index
    checkbox.value = index
    checkbox.checked = false
    checkbox.addEventListener('click', checkBoxEvent)
    return checkbox;
}

function createLabel (text, index)
{
    let tag = document.createElement('label')
    tag.htmlFor = index
    tag.className = 'label form-check-label'
    tag.innerHTML = text

    return tag
}

function createRow ()
{
    return document.createElement('tr')
}

function createColumn (_class)
{
    let tag = document.createElement('td')
    tag.className = _class

    return tag
}

function checkBoxEvent ()
{
    if (this.checked === true)
    {
        selectedNoti.push(this.value)
    }
    else
    {
        selectedNoti.splice(selectedNoti.lastIndexOf(this.value), 1)
    }
}

function extractContent (content)
{
    let pos = content.search('<a>')
    if (pos === -1)
    {
        return [content, '']
    }
    let newContent = content.substr(0, pos - 1)
    let link = content.substr(pos)

    return [newContent, link]
}

function attachLink (tdTag, link)
{
    let arrLink = link.match(/<a>.+<\/a>/)
    for (let singleLink of arrLink)
    {
        singleLink = singleLink.replace('<a>', '')
        singleLink = singleLink.replace('</a>', '')
        let aTag = document.createElement('a')
        aTag.href = singleLink
        aTag.innerHTML = getFileName(singleLink)
        tdTag.append(aTag)
    }
}

function getFileName (link)
{
    let decodedLink = decodeURI(link);
    let arrPath = decodedLink.split('/')
    let fileName = arrPath[arrPath.length - 1]

    return fileName;
}

/*--------------------------------------*/
function getInvalidField (data)
{
    if (data.length === 0)
    {
        return 'Checkbox thông báo không được để trống'
    }

    return null
}

CustomConfirm('button', async function (confirmed, element)
{
    if (confirmed)
    {
        let message = getInvalidField(selectedNoti)
        if (message !== null)
        {
            raiseEmptyFieldError(message)
            return
        }
        let response = await postData('web/notification/set-delete', selectedNoti)
        if (response.status === 200)
        {
            raiseSuccess('Xóa thông báo thành công!', 'Tiếp tục xóa thông báo', 'home')
        }
        else
        {
            raiseBackEndError(1)
        }
    }
});

