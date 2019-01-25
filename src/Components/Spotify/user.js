import React, { Component } from 'react'

class User extends Component {
    render() {
        if (typeof this.props.user === 'object' && this.props.user !== null) {
            return (
                <>
                    <div className="logged-in-user">
                        <figure>
                            <img src={this.props.user.image} alt={this.props.user.name}/>
                            <figcaption>{this.props.user.name}</figcaption>
                        </figure>
                    </div>
                </>
            )
        }
        return (
            <p>No user is logged in</p>
        )
    }
}

export default User
