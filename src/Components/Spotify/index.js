import React, { Component } from 'react'

const API = 'http://86.90.190.118/system/tools/spotify';
const DEFAULT_QUERY = '';

class Spotify extends Component {
    constructor(props) {
        super(props);

        this.state = {
            hits: [],
        };
    }

    componentDidMount() {
        fetch(API + DEFAULT_QUERY)
            .then(response => response.json())
            .then(data => this.setState({ hits: data.hits }));
    }

    render() {
        return (
            <>
                <spotify>
                    <currentSong>
                        <album>
                            <img src="" alt=""/>
                        </album>
                        <title>Title</title>
                        <artist>Artist</artist>
                    </currentSong>
                </spotify>
            </>
        )
    }
}

export default Spotify
