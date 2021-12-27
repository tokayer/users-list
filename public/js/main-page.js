const getUsers = () => {
    fetch('online-user-list')
        .then(response => response.json())
        .then(users => {
            console.log(users)
            document.querySelectorAll('.user-row').forEach(tr => tr.remove())
            for (const user of users) {
                appendUser(user)
            }
        })
}

getUsers();

const interval = setInterval(function() {
    getUsers()
}, 3000)

const appendUser = (user) => {
    const usersTable = document.querySelector('.users-table')
    let userRow = document.createElement('tr') // Create the current table row
    userRow.className = 'user-row'

    let name = document.createElement('td')
    name.innerText = user.name
    let lastEntrance = document.createElement('td')
    lastEntrance.innerText = user.last_entrance
    let lastUpdate = document.createElement('td')
    lastUpdate.innerText = user.last_update
    let ip = document.createElement('td')
    ip.innerText = user.ip

    userRow.append(name, lastEntrance, lastUpdate, ip)
    usersTable.append(userRow)
}


window.addEventListener("beforeunload", function (e) {
    let currentUser = document.querySelector('#current-user')

    if (currentUser == null) {
        return
    }

    let userEmail = currentUser.getAttribute('data-email')
    fetch('/user-offline', {
        method: 'POST',
        body: JSON.stringify({email: userEmail})
    })
        .then(response => response.json())
        .then(users => {
            console.log(users)
            document.querySelectorAll('.user-row').forEach(tr => tr.remove())
            for (const user of users) {
                appendUser(user)
            }
        })
});