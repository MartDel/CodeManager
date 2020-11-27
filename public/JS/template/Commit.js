class Commit {
    constructor(json) {
        const commit = json['commit']
        const author = commit['author']

        this.sha = json['sha']
        this.author_name = author['name']
        this.author_mail = author['email']
        this.message = commit['message']
        this.date = author['date']
    }

    getDisplay(){
        return this.author_name + ' [' + this.author_mail + '] : ' + this.getMessage(true) + ' | Date : ' + this.getDate() + ' (' + this.getSha(6) + ')'
    }

    getDate(){
        const date = new Date(this.date)
        return date.toLocaleDateString()
    }

    getSha(size = null){
        return size ? this.sha.substring(0, size) : this.sha
    }

    getMessage(br = false){
        return br ? this.message.replaceAll('<br>', ' ').replaceAll('\n', ' ') : this.message
    }
}
