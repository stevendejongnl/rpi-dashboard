import React, {Component} from 'react'

const API = 'http://local.rpi3/system/tools/spotify/';

class Track extends Component {
  constructor(props) {
    super(props);
    this.state = {
      tryData: ""
    }
  }

  getImage() {
    if (typeof this.props.track.item !== "undefined" && typeof this.props.track.item.images !== "undefined") {
      return <img src={this.props.track.item.images[0].url} alt=""/>;
    }
  };

  getArtists() {
    if (typeof this.props.track.item !== "undefined" && typeof this.props.track.item.artists !== "undefined") {
      let artistsList = '';
      for (let artist of this.props.track.item.artists) artistsList = artistsList + (artistsList !== '' ? ', ' : '') + artist.name;
      return artistsList;
    }
  };

  getName() {
    if (typeof this.props.track.item !== "undefined" && typeof this.props.track.item.name !== "undefined") {
      return this.props.track.item.name
    }
  };

  playback = (type) => {
    (async () => {
      const rawResponse = await fetch(API, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({action: type})
      })
        .then(response => response.json())
        .then(data => {
          this.setState({
            tryData: data
          })
        })
        .catch((error) => {
          console.log(error, "catch the hoop")
        });
    })();
  };

  render() {
    if (typeof this.props.track === 'object' && this.props.track !== null) {
      return (
        <>
          <div className="play _previous">
            <button type="submit" onClick={() => { this.playback('previous') }}>Previous</button>
          </div>

          <div className="track">
            <figure>
              {this.getImage()}
              <figcaption>
                <div className="playToggle">
                  <button type="submit" onClick={() => { this.playback('togglePlay') }}>Play/Pause</button>
                </div>
                <div className="artists">
                  {this.getArtists()}
                </div>
                <div className="track-name">
                  {this.getName()}
                </div>
              </figcaption>
            </figure>
          </div>

          <div className="play _next">
            <button type="submit" onClick={() => { this.playback('next') }}>Next</button>
          </div>
        </>
      )
    }

    return (
      <p>No track is playing</p>
    )
  }
}

export default Track
