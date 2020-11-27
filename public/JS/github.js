const commits = {
    username: document.getElementById('username').value,
    project: document.getElementById('project').value,
    ul: document.getElementById('commits'),
    loading: document.getElementById('loading'),
    more: document.getElementById('more'),
    switch_branch: document.getElementById('switch_branch')
}
const params = new URLSearchParams(window.location.search)

window.onload = () => {
    const branch = params.has('branch') ? params.get('branch') : 'master'
    getMoreCommits(branch)
    commits.switch_branch.value = branch
}

commits.switch_branch.onchange = (event) => {
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
            const err = new Message('error', 'Mauvaise nouvelle...', "Une erreur s'est produite. Vérifiez votre connexion Internet.")
            err.dynamic = () => location.reload()
            err.btn2 = 'refresh'
            err.show()
        });
}

function getMoreCommits(last_sha = 'master'){
    commits.loading.style.display = 'block'
    commits.more.style.display =  'none'
    getCommits((data) => {
        commits.loading.style.display = 'none'
        if(data.length === 30){
            commits.more.style.display =  'inline-block'
            commits.more.onclick = () => getMoreCommits(data[data.length-1].sha)
        }
        console.log(data);

        if(data.message){
            const err = new Message('error', 'Mauvaise nouvelle...', "Une erreur s'est produite. Vérifiez votre connexion Internet.")
            err.dynamic = () => location.reload()
            err.btn2 = 'refresh'
            err.show()
            return;
        }

        if(data.length == 0){
            // Pas de commits
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
