import React, { Component } from 'react';

class FooterMenu extends Component {

    constructor(props) {
        super(props);
        this.state = {
            dataFooterMenu: []
        };
    }

    componentDidMount() {
        let myHeaders = new Headers();
        myHeaders.append('pragma', 'no-cache');
        myHeaders.append('cache-control', 'no-cache');
        
        let myInit = {
          method: 'GET',
          headers: myHeaders,
        };

        fetch(process.env.PUBLIC_URL + "/assets/content/footer/footerMenu.json",myInit).then(response => {
            return response.json();
        }).then(data => {
            this.setState({ dataFooterMenu: data });
        });
    }

    render() {
        return (
            <nav className="menu-secondary">
                <ul className="clearfix list-unstyled">
                    {this.state.dataFooterMenu.map((item, key) => {
                        return (
                            <li key={key}>
                                <a
                                    title={item.title}
                                    className="btn btn-link transform-scale-h border-0 p-0"
                                    href={item.link}
                                    target={'_blank'}
                                >
                                    {item.title}
                                </a>
                            </li>
                        );
                    })}
                </ul>
            </nav>
        );
    }

}
export default FooterMenu;
