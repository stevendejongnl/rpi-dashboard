import React, { Component } from 'react'
import User from './user'
import Track from './track'

// const API = 'http://86.90.190.118/system/tools/spotify/';
const API = 'http://local.rpi3/system/tools/spotify/';

class Spotify extends Component {
    constructor(props) {
        super(props);

        this.state = {
            user: [],
            track: [],
            devices: []
        };
    }

    componentDidMount() {
        fetch(API, {
            crossDomain: true,
            method: 'GET',
            headers: {'Content-Type': 'application/json'},
        })
            .then(response => response.json())
            .then(data => this.setState({ user: data.user, track: data.track, devices: data.devices }));
    }

    render() {
        console.log(this.state);

        if (typeof this.state.user.name !== "undefined" && typeof this.state.track.is_playing !== "undefined") {
            return (
                <div className="spotify">
                    <User user={this.state.user}/>

                    <Track track={this.state.track}/>
                </div>
            )
        } else {
            return (
                <>
                    <p>Spotify is loading...</p>
                </>
            )
        }
    }
}

export default Spotify
