import axios from 'axios';

class Github {
    async latestRelease(user, repository) {
        const response = await this.performQuery(user, repository);

        return response.data;
    }

    async performQuery(user, repository) {
        const endpoint = `https://api.github.com/repos/${user}/${repository}/releases/latest`;

        delete axios.defaults.headers.common['X-CSRF-TOKEN'];
        return await axios.get(endpoint);
    }
}

export default new Github();
