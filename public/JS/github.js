const commits = {
    username: document.getElementById('username').value,
    project: document.getElementById('project').value,
    container: document.getElementById('container'),
    ul: document.getElementById('commits'),
    loading: document.getElementById('loading'),
    switch_branch: document.getElementById('switch_branch'),
    no_commit: document.getElementById('no_commit')
}
const params = new URLSearchParams(location.search)
let delay = true
let last_sha = null

window.onload = () => {
    const branch = params.has('branch') ? params.get('branch') : 'master'
    getMoreCommits(branch)
    commits.switch_branch.value = branch
}

commits.container.onscroll = () => {
    const current = commits.container.scrollTop
    const limit = commits.container.scrollHeight - commits.container.offsetHeight
    if(delay && current >= limit && window.last_sha){
        delay = false
        getMoreCommits(window.last_sha)
        setTimeout(() => delay = true, 1000)
    }
}

commits.switch_branch.onchange = () => {
    const branch = commits.switch_branch.value
    commits.ul.innerHTML = ''
    getMoreCommits(branch)
    params.set('branch', branch)
    setURLParams(params.toString())
}

function getCommits(callback, sha = 'master'){
    const url = "https://api.github.com/repos/" + commits.username + "/" + commits.project + "/commits?sha=" + sha
    fetch(url)
        .then((response) => { return response.json() })
        .then((data) => {
            setTimeout(() => { callback(data) }, 500)
        })
        .catch((error) => {
            errorGitHub()
        });
}

function getMoreCommits(last_sha = 'master'){
    commits.loading.style.display = 'block'
    commits.no_commit.style.display =  'none'
    getCommits((data) => {
        commits.loading.style.display = 'none'
        window.last_sha = data.length === 30 ? data[data.length-1].sha : null

        if(data.message){
            // Erreur GitHub
            errorGitHub()
            return;
        }

        if(data.length == 0){
            // Pas de commits
            commits.no_commit.style.display = 'block'
            return;
        }

        data.forEach((json) => {
            const commit = new Commit(json)
            if(commit.getSha() !== last_sha){
                const li = document.createElement('li')
                li.innerText = commit.getDisplay()
                commits.ul.appendChild(li)
            }
        })
    }, last_sha)
}

function errorGitHub(){
    commits.switch_branch.value = 'master'
    commits.ul.innerHTML = ''
    params.delete('branch')
    setURLParams(params.toString())
    const err = new Message('error', 'Mauvaise nouvelle...', "Une erreur s'est produite. Vérifiez votre connexion Internet.")
    err.show()
}
