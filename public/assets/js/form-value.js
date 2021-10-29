/**
 * Clear form by range of data
 *
 * @param data
 */
function clearSelectedFormInput(...data) {
    data.forEach(function (item, index) {
        console.log('data' + item + index)
        document.getElementById(item).value = ""
    })
}
