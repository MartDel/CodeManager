const commits = {
    username: username.value,
    project: project.value,
    ul: document.getElementById('commits'),
    loading: document.getElementById('loading'),
    more: document.getElementById('more')
}

window.onload = () => {
    getMoreCommits()
}

function getCommits(callback, sha = null){
    const url = "https://api.github.com/repos/" + commits.username + "/" + commits.project + "/commits" + (sha ? '?sha=' + sha : '')
    fetch(url)
        .then((response) => { return response.json() })
        .then((data) => {
            setTimeout(() => { callback(data) }, 500)
        })
        .catch((error) => { console.error(error) });
}

function getMoreCommits(last_sha = null){
    commits.loading.style.display = 'block'
    commits.more.style.display =  'none'
    getCommits((data) => {
        commits.loading.style.display = 'none'
        if(data.length === 30){
            commits.more.style.display =  'inline-block'
            commits.more.onclick = () => getMoreCommits(data[data.length-1].sha)
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
