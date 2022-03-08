import React from 'react';
import { Link } from 'react-router-dom';

const Logo = ( { image } ) => {
    return (
        <div className="logo logo-fixed">
            <Link to={ process.env.PUBLIC_URL + "/" }><div class="logo-margin-bottom"><h5>Gabriele Ciances</h5></div><h6>REGISTA</h6>
            </Link>
        </div>
    );
};

export default Logo;
