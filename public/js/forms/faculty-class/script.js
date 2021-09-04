import {autoFillTemplate, resetInputDate, changeStatusButton, listerEnterKey} from '../shared_form_functions.js'
import {fetchData, postData} from '../../shared_functions.js'
import {raiseBackEndError, raiseEmptyFieldError, raiseSuccess} from '../../alerts.js'

let allClass = []
let selectedClass = []
let allAcademicYears = []
let allFaculties = ['CK', 'CNTT', 'CT', 'DDT', 'DTQT', 'KHCB', 'KTXD', 'MT&ATGT', 'QLXD', 'VTKT', 'KHOAKHAC']
let academicYears = []
let faculties = []

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
    let data = await fetchData('../web/forms/faculty-class')
    allAcademicYears = data[0];
    allClass = data[1];

    createAcademicCheckBoxArea()

    document.getElementById('all_academic_year').addEventListener('click', tickAllForAcademicYearAndFaculty)
    document.getElementById('all_faculty').addEventListener('click', tickAllForAcademicYearAndFaculty)
    document.getElementById('submit_btn').addEventListener('click', pushNotification)
    document.getElementById('template').addEventListener('change', fillForms)
    document.getElementById('attach-link').addEventListener('keyup', listerEnterKey)
    document.getElementsByName('reset_button')[0].addEventListener('click', resetInputDate)
    document.getElementsByName('reset_button')[0].addEventListener('click', changeStatusButton)
    document.getElementsByName('reset_button')[1].addEventListener('click', resetInputDate)
    document.getElementsByName('reset_button')[1].addEventListener('click', changeStatusButton)
    document.getElementById('time-start').addEventListener('change', changeStatusButton)
    document.getElementById('time-end').addEventListener('change', changeStatusButton)

    addEventForAcademicYearAndFaculty()
})

/*_____________INITIALIZATION____________________________________*/


let academicYearCheckboxes = document.getElementsByName('academic_year')
let facultyCheckboxes = document.getElementsByName('faculty')


/*_________________________________________________*/

function createAcademicCheckBoxArea ()
{
    let parentNode = document.getElementById('academic_year_area')
    parentNode.appendChild(createAcademicYearCheckAll())

    for (let item of allAcademicYears)
    {
        parentNode.appendChild(createAcademicCheckBox(item))
    }
}

function createAcademicYearCheckAll ()
{
    let div = document.createElement('div')
    div.className = 'form-check form-check-inline';

    let input = document.createElement('input')
    input.type = 'checkbox'
    input.className = 'academic_year form-check-input academic-year-faculty pointer'
    input.id = 'all_academic_year'
    input.value = 'all'

    let label = document.createElement('label')
    label.htmlFor = 'all_academic_year'
    label.className = 'pointer form-check-label'
    label.innerHTML = 'Chọn tất cả'

    div.appendChild(input)
    div.appendChild(label)

    return div
}

function createAcademicCheckBox (value)
{
    let div = document.createElement('div')
    div.className = 'form-check form-check-inline';

    let input = document.createElement('input')
    input.type = 'checkbox'
    input.className = 'academic_year form-check-input academic-year-faculty pointer'
    input.id = value
    input.name = 'academic_year'
    input.value = value

    let label = document.createElement('label')
    label.htmlFor = value
    label.className = 'pointer form-check-label'
    label.innerHTML = value

    div.appendChild(input)
    div.appendChild(label)

    return div
}

function tickAllForAcademicYearAndFaculty ()
{
    let checkBoxes = document.getElementsByName(this.classList[0])

    for (let i = 0; i < checkBoxes.length; i++)
    {
        checkBoxes[i].checked = this.checked
    }
}

function addEventForAcademicYearAndFaculty ()
{
    const checkBox = document.getElementsByClassName('academic-year-faculty')

    for (let i = 0; i < checkBox.length; i++)
    {
        checkBox[i].addEventListener('change', function ()
        {
            if (!this.checked && this.value !== 'all')
            {
                document.getElementsByClassName(this.name)[0].checked = false
            }
            else if (this.checked && this.value !== 'all')
            {
                let checkBoxes = document.getElementsByName(this.name)
                let flag = true
                for (let j = 0; j < checkBoxes.length; j++)
                {
                    if (!checkBoxes[j].checked)
                    {
                        flag = false
                        break
                    }
                }
                document.getElementsByClassName(this.name)[0].checked = flag
            }

            if (!isChecked())
            {
                reset()
                return
            }

            getConditions()
        })
    }
}

function isChecked ()
{
    let flag1 = false
    let flag2 = false
    for (let i = 0; i < academicYearCheckboxes.length; i++)
    {
        if (academicYearCheckboxes[i].checked)
        {
            flag1 = true
            break
        }
    }
    for (let i = 0; i < facultyCheckboxes.length; i++)
    {
        if (facultyCheckboxes[i].checked)
        {
            flag2 = true
            break
        }
    }

    return (flag1 && flag2)
}

function reset ()
{
    document.querySelector('.class').innerHTML = ''
    selectedClass = []
}

function getConditions ()
{
    academicYears = []
    faculties = []

    if ($('#all_academic_year').is(':checked'))
    {
        if ($('#all_faculty').is(':checked'))
        {
            academicYears = allAcademicYears
            faculties = allFaculties
        }
        else
        {
            academicYears = allAcademicYears

            for (let i = 0; i < facultyCheckboxes.length; i++)
            {
                if (facultyCheckboxes[i].checked)
                {
                    faculties.push(facultyCheckboxes[i].value)
                }
            }
        }
    }
    else
    {
        if ($('#all_faculty').is(':checked'))
        {
            faculties = allFaculties

            for (let i = 0; i < academicYearCheckboxes.length; i++)
            {
                if (academicYearCheckboxes[i].checked)
                {
                    academicYears.push(academicYearCheckboxes[i].value)
                }
            }
        }
        else
        {
            for (let i = 0; i < academicYearCheckboxes.length; i++)
            {
                if (academicYearCheckboxes[i].checked)
                {
                    academicYears.push(academicYearCheckboxes[i].value)
                }
            }

            for (let i = 0; i < facultyCheckboxes.length; i++)
            {
                if (facultyCheckboxes[i].checked)
                {
                    faculties.push(facultyCheckboxes[i].value)
                }
            }
        }
    }

    getClass()
}

function getClass ()
{
    let data = {}

    for (let _class of allClass)
    {
        let {academic_year: academicYearOfClass, id_faculty: facultyOfClass, id_class: idOfClass} = _class

        if (academicYears.lastIndexOf(academicYearOfClass) !== -1 &&
            faculties.lastIndexOf(facultyOfClass) !== -1)
        {

            if (data[academicYearOfClass] === undefined)
            {
                data[academicYearOfClass] = {}
            }

            if (data[academicYearOfClass][facultyOfClass] === undefined)
            {
                data[academicYearOfClass][facultyOfClass] = []
            }

            data[academicYearOfClass][facultyOfClass].push(idOfClass)
        }
        createTable(data)
    }
}

function createTable (data)
{
    reset()

    if (Object.entries(data).length === 0)
    {
        return
    }

    for (const [_academicYear, _faculty] of Object.entries(data))
    {
        let area = createAcademicYearArea(_academicYear)
        let innerTable = createInnerTable()

        for (const [facultyElement, _class] of Object.entries(_faculty))
        {
            let rowTag = createRow()
            let columnFacultyTag = createColumn()
            let facultyTag = createFacultyTag(facultyElement)
            let checkAllTag = createCheckAllTag(_academicYear, facultyElement)
            let columnCheckAllTag = createColumn()

            columnFacultyTag.appendChild(facultyTag)
            rowTag.appendChild(columnFacultyTag)

            columnCheckAllTag.appendChild(checkAllTag)
            rowTag.appendChild(columnCheckAllTag)

            let counter = 2
            for (const _singleClass of _class)
            {
                selectedClass.push(_singleClass)

                let classTag = createClassTag(_singleClass, _academicYear, facultyElement)
                let columnClassTag = createColumn()

                if (counter >= 8)
                {
                    innerTable.appendChild(rowTag)

                    rowTag = createRow()

                    rowTag.appendChild(createColumn())
                    rowTag.appendChild(createColumn())

                    counter = 2
                }
                columnClassTag.appendChild(classTag)
                rowTag.appendChild(columnClassTag)

                counter++
            }
            if (counter < 7)
            {
                for (; counter < 8; counter++)
                {
                    rowTag.appendChild(createColumn())
                }
            }

            innerTable.appendChild(rowTag)
        }

        document.querySelector('.class').appendChild(area)
        document.querySelector('.class').appendChild(innerTable)
    }

    addEventToClass()
    document.getElementsByClassName('class')[0].scrollIntoView(false)
}

function createAcademicYearArea (academicYear)
{
    let tag = document.createElement('legend')
    tag.innerHTML = academicYear

    return tag
}

function createInnerTable ()
{
    let table = document.createElement('table')
    table.className = 'form-group'

    return table
}

function createRow ()
{
    return document.createElement('tr')
}

function createColumn ()
{
    return document.createElement('td')
}

function createFacultyTag (faculty)
{
    let tag = document.createElement('div')
    tag.innerHTML = faculty
    tag.className = 'form-check form-check-inline'

    return tag
}

function createCheckAllTag (academicYear, faculty)
{
    let tag = document.createElement('div')
    tag.className = 'form-check form-check-inline'

    let checkbox = document.createElement('input')
    checkbox.type = 'checkbox'
    checkbox.className = academicYear + faculty + ` form-check-input pointer`
    checkbox.id = academicYear + faculty
    checkbox.value = 'all'
    checkbox.addEventListener('click', tickAllForClass)
    checkbox.checked = true

    let label = document.createElement('label')
    label.htmlFor = academicYear + faculty
    label.className = 'pointer form-check-label text-nowrap'
    label.innerHTML = 'Chọn tất cả'

    tag.appendChild(checkbox)
    tag.appendChild(label)

    return tag
}

function createClassTag (_class, academicYear, faculty)
{
    let tag = document.createElement('div')
    tag.className = 'form-check form-check-inline'

    let checkbox = document.createElement('input')
    checkbox.type = 'checkbox'
    checkbox.className = academicYear + faculty + ` form-check-input class-checkbox pointer`
    checkbox.id = _class
    checkbox.name = academicYear + faculty
    checkbox.value = _class
    checkbox.checked = true

    let label = document.createElement('label')
    label.htmlFor = _class
    label.className = 'pointer form-check-label text-nowrap'
    label.innerHTML = _class

    tag.appendChild(checkbox)
    tag.appendChild(label)

    return tag
}

function tickAllForClass ()
{
    let checkBoxes = document.getElementsByName(this.classList[0])

    for (let i = 0; i < checkBoxes.length; i++)
    {
        if (checkBoxes[i].checked !== this.checked)
        {
            checkBoxes[i].checked = this.checked
            if (this.checked)
            {
                selectedClass.push(checkBoxes[i].value)
            }
            else
            {
                selectedClass.splice(selectedClass.lastIndexOf(checkBoxes[i].value), 1)
            }
        }
    }
}

function addEventToClass ()
{
    let checkBoxClass = document.getElementsByClassName('class-checkbox')

    for (let i = 0; i < checkBoxClass.length; i++)
    {
        checkBoxClass[i].addEventListener('change', function ()
        {
            if (!this.checked && this.value !== 'all')
            {
                selectedClass.splice(selectedClass.lastIndexOf(this.value), 1)

                document.getElementsByClassName(this.name)[0].checked = false
            }
            else if (this.checked && this.value !== 'all')
            {
                selectedClass.push(this.value)

                let checkBoxes = document.getElementsByName(this.name)
                let flag = true
                for (let j = 0; j < checkBoxes.length; j++)
                {
                    if (!checkBoxes[j].checked)
                    {
                        flag = false
                        break
                    }
                }
                document.getElementsByClassName(this.name)[0].checked = flag
            }
        })
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
        return 'Checkbox chọn lớp không được để trống'
    }

    return null
}

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
        class_list: selectedClass,
    }

    let message = getInvalidField(data)
    if (message !== null)
    {
        raiseEmptyFieldError(message)
        return
    }

    const url = '../web/notification/push-notification/faculty-class'
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

function fillForms ()
{
    autoFillTemplate(templateNoti[template.value])
}
