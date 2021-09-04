import {autoFillTemplate, resetInputDate, changeStatusButton, listerEnterKey} from '../shared_form_functions.js'
import {fetchData, postData} from '../../shared_functions.js'
import {raiseBackEndError, raiseEmptyFieldError, raiseSuccess} from '../../alerts.js'

let moduleClassIdList = []

const moduleClassId = $('#module-class-id')
const fieldList = {
    title: 'Tiêu đề',
    content: 'Nội dung',
    type: 'Loại thông báo'
}

const templateNoti = {
    study: {
        title: 'Học tập',
        content: 'Nội dung thông báo học tập',
        type: 0
    },
    fee: {
        title: 'Học phí',
        content: 'Nội dung thông báo học phí',
        type: 1
    },
    extracurricular: {
        title: 'Thông báo ngoại khóa',
        content: 'Nội dung thông báo ngoại khóa',
        type: 2
    },
    social_payment: {
        title: 'Chi trả xã hội',
        content: 'Nội dung thông báo chi trả xã hội',
        type: 3
    },
    others: {
        title: 'Thông báo khác',
        content: 'Nội dung thông báo khác',
        type: 4
    }
}

/*_________________________________________________*/

document.addEventListener('DOMContentLoaded', async () =>
{
    const CustomSelectionAdapter = $.fn.select2.amd.require('select2/selection/customSelectionAdapter')

    await loadData()

    document.getElementById('submit_btn').addEventListener('click', pushNotification)
    document.getElementById('template').addEventListener('change', fillForms)
    document.getElementById('attach-link').addEventListener('keyup', listerEnterKey)
    document.getElementsByName('reset_button')[0].addEventListener('click', resetInputDate)
    document.getElementsByName('reset_button')[0].addEventListener('click', changeStatusButton)
    document.getElementsByName('reset_button')[1].addEventListener('click', resetInputDate)
    document.getElementsByName('reset_button')[1].addEventListener('click', changeStatusButton)
    document.getElementById('time-start').addEventListener('change', changeStatusButton)
    document.getElementById('time-end').addEventListener('change', changeStatusButton)

    //  Display selected tags
    moduleClassId.select2({
        data: moduleClassIdList,
        selectionAdapter: CustomSelectionAdapter,
        allowClear: false,
        selectionContainer: $('#list'),
        theme: 'bootstrap4'
    })
})

/*_________________________________________________*/

async function loadData ()
{
    let data = await fetchData('../web/forms/module-class')

    data.forEach((row, index) =>
    {
        moduleClassIdList.push({id: index, text: row['id_module_class']})
    })
}

/*_________________________________________________*/

function getClassList ()
{
    let selectedId = moduleClassId.val()

    if (selectedId.length === 0)
    {
        return []
    }

    let selectedClasses = selectedId.map((_class) => moduleClassIdList[_class].text)
    return selectedClasses
}

/*_________________________________________________*/

async function pushNotification ()
{
    let timeStartRsBtClass = document.getElementsByClassName('time-start')[0].classList[3]
    let timeEndRsBtClass = document.getElementsByClassName('time-end')[0].classList[3]

    let csrf_token = $('[name="_token"]').attr('content')
    let title = $('#title').val()
    let content = $('#content').val()
    let type = $('#type').val()
    let id_sender = $('[name="id_"]').val()

    const data = {
        token: csrf_token,
        info: {
            title: title,
            content: content,
            type: type,
            time_start: timeStartRsBtClass === 'disable' ? null : $('#time-start').val() + ' 00:00:00.00',
            time_end: timeEndRsBtClass === 'disable' ? null : $('#time-end').val() + '  23:59:59.00',
            id_sender: id_sender
        },
        class_list: getClassList(),
    }

    let message = getInvalidField(data)
    if (message !== null)
    {
        raiseEmptyFieldError(message)
        return
    }

    const url = '../web/notification/push-notification/module-class'
    let response = await postData(url, data)

    if (response.status === 200)
    {
        raiseSuccess('Thêm thông báo thành công!', 'Tạo thông báo mới', '../home')
        document.getElementById('submit_btn').removeEventListener('click', pushNotification)
    }
    else
    {
        raiseBackEndError(1)
    }
}

function getInvalidField (data)
{
    for (const [field, fieldValue] of Object.entries(data.info))
    {
        if (fieldValue === '' && fieldList[field] !== undefined)
        {
            return fieldList[field] + ' không được để trống'
        }
    }

    if (data.class_list.length === 0)
    {
        return 'Mã học phần không được để trống'
    }

    return null
}

/*-------------------------------------------------*/

function fillForms ()
{
    autoFillTemplate(templateNoti[template.value])
}
