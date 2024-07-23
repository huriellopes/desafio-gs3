export default () => {
    const search = document.getElementById('search')

    search.addEventListener('keyup', function (e) {
        e.preventDefault()

        axios({
            method: 'GET',
            url: `/users?search=${e.target.value}`
        }).then(res => {
            console.log(res)
        })

        console.log(e.target.value)
    })
}
