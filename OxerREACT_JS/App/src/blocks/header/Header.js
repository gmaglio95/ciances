import React from 'react';
import Logo from '../../blocks/logo/Logo';
import SearchModal from '../../components/modal/SearchModal';
import MenuModal from '../../components/modal/MenuModal';
import Menu from '../../components/menu/Menu'

const Header = () => {
    return (
        <header id="header" className="site-header">
            <div className="wrapper d-flex justify-content-between">
                <div className="align-self-center">
                    <Logo image={ "/assets/img/logo/logo.png" } />
                </div>

                {/* <SearchModal /> */}

                <Menu />

            </div>
        </header>
    );
};

export default Header;
