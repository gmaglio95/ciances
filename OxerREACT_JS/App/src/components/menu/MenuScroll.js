import React, { Component, Fragment } from 'react';
import { Link } from 'react-scroll';

class MenuScroll extends Component {


    render() {
        return (
            <Fragment>
                <nav className="menu-secondary">
                    <ul className="clearfix list-unstyled">
                        <li key="Work">
                            <Link activeClass="active" to="work" className="btn btn-link transform-scale-h border-0 p-0" spy={true} smooth={true}>Work</Link>
                        </li>
                        <li key="About">
                            <Link activeClass="active" to="about" className="btn btn-link transform-scale-h border-0 p-0" spy={true} smooth={true}>Bio</Link>
                        </li>
                        <li key="Contacts">
                            <a title="Home" className="btn btn-link transform-scale-h border-0 p-0" href={process.env.PUBLIC_URL + "/contacts"}>Contatti</a>
                        </li>
                    </ul>
                </nav>
            </Fragment>
        );


    }
}
export default MenuScroll;