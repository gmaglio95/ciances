import React from 'react';
import Logo from '../../blocks/logo/Logo';
import Menu from '../../components/menu/Menu'
import MenuScroll from '../../components/menu/MenuScroll';

const HeaderScroll = () => {
    return (
        <header id="header" className="site-header">
            <div className="wrapper d-flex justify-content-between">
                <div className="align-self-center">
                    <Logo image={ "/assets/img/logo/logo.svg" } />
                </div>

                {/* <SearchModal /> */}

                <MenuScroll />

            </div>
        </header>
    );
};

export default HeaderScroll;
