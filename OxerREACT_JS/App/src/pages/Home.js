import React, { Fragment } from 'react';
import MetaTags from 'react-meta-tags';

import Loading from '../blocks/loading/Loading';
import Header from '../blocks/header/Header';
import Footer from '../blocks/footer/Footer';

import PageTitleHome from '../blocks/page-title/PageTitleHome';
import Works from '../blocks/works/Works';
import Journal from '../blocks/blog/Blog';
import Contacts from '../blocks/contacts/Contacts';
import AboutContent from '../blocks/about/AboutContent';
import HeaderScroll from '../blocks/header/HeaderScroll';

const Home = () => {


    document.body.classList.add('home');
    document.body.classList.add('bg-fixed');


    return (
        <Fragment>

            <MetaTags>
                <meta charSet="UTF-8" />
                <title>Home | Oxer - Minimal Portfolio React Template</title>

                <meta httpEquiv="x-ua-compatible" content="ie=edge" />
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <meta name="description" content="" />
                <meta name="keywords" content="" />
                <meta name="robots" content="index, follow, noodp" />
                <meta name="googlebot" content="index, follow" />
                <meta name="google" content="notranslate" />
                <meta name="format-detection" content="telephone=no" />
            </MetaTags>

            <Loading />

            <HeaderScroll />

            <main id="main" className="site-main">
                <div id="work">
                    <Works />
                </div>
                <div id="about">
                    <AboutContent />
                </div>
                <div id="contact">
                    <Contacts />
                </div>
            </main>

            <Footer />
        </Fragment>
    );
};

export default Home;
