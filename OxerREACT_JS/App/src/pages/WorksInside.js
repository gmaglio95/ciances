import React, { Component, Fragment } from 'react';
import MetaTags from 'react-meta-tags';

import Loading from '../blocks/loading/Loading';
import Header from '../blocks/header/Header';
import Footer from '../blocks/footer/Footer';
import WorksInsideJson from '../data/works/works-inside.json';
import WorksInsideImageJson from '../data/works/works-inside-images.json';
import GalleryItemsData from '../data/gallery/galleryItems';

class WorksInside extends Component {


    constructor(props) {
        super(props);
        this.state = {
            workInsideItem: {},
            imageList: [],
            galleryImgLink: {}
        }
    }

    filterValueByIdGallery(value) {
        let element;
        for (let el in Object.values(value)) {
            if (value[el].idGallery == this.props.match.params.id) {
                element = value[el];
            }
        }
        return element;
    }

    componentDidMount() {
        let workInside = Object(WorksInsideJson.filter(work => {
            return work.idGallery == this.props.match.params.id;
        }));
        let images = Object(WorksInsideImageJson.filter(work => {
            return work.idGallery == this.props.match.params.id;
        }));

        let gallery = Object(GalleryItemsData.filter(gallery => {
            return gallery.id == this.props.match.params.id;
        }));

        this.setState({ workInsideItem: workInside[0], imageList: images, galleryImgLink: gallery[0].imgLink });
    }


    render() {
        document.body.classList.add('single');
        document.body.classList.add('single-portfolio');
        document.body.classList.add('bg-fixed');
        return (
            <Fragment>
                <MetaTags>
                    <meta charSet="UTF-8" />
                    <title>Works Inside | Oxer - Minimal Portfolio React Template</title>

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

                <Header />

                <main id="main" className="site-main bg-half-ring-right bg-half-ring-top">
                    <section id="page-content">
                        <div className="wrapper">
                            <div id="single">


                                <div className="row gutter-width-lg single-content" >
                                    <div className="col-xl-6 col-lg-6 col-md-6 col-sm-6">

                                        <h1 className="small">{this.state.workInsideItem.title}</h1>
                                        <h5 className="small">
                                            {this.state.workInsideItem.subTitle}
                                        </h5>
                                        <div className="description">
                                            <div className="inline-div"> Guarda <div className="inline-div"><h6>{this.state.workInsideItem.title}</h6></div> al link </div>
                                            <div className="margin-bottom-top"><a className="btn btn-link transform-scale-h border-0 p-0" href={this.state.workInsideItem.linkSite}> {this.state.workInsideItem.title} </a> </div>
                                        </div>
                                        <h3>Credits</h3>
                                        <div className="row gutter-width-lg single-content" >
                                            <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div className="description ">
                                                    <div class="inline-div ">Diretto Da : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.direzione}</h6></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="row gutter-width-lg single-content" >
                                            <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div className="description">
                                                    <div class="inline-div ">Montato Da : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.montaggio}</h6></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="row gutter-width-lg single-content" >
                                            <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div className="description ">
                                                    <div class="inline-div ">Scritto Da : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.scrittura}</h6></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="row gutter-width-lg single-content" >
                                            <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div className="description ">
                                                    <div class="inline-div ">Distribuito Da : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.distribuzione}</h6></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="row gutter-width-lg single-content" >
                                            <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div className="description ">
                                                    <div class="inline-div ">Prodotto Da : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.produzione}</h6></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="row gutter-width-lg single-content" >
                                            <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div className="description ">
                                                    <div class="inline-div ">Produttori Esecutivi : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.produzioneEsecutiva}</h6></div>
                                                </div>
                                            </div>
                                        </div>
                                        {/* <div className='margin-bottom-top'>{this.state.workInsideItem.credits}</div> */}
                                    </div>
                                    <div className="col-xl-6 col-lg-6 col-md-6 col-sm-6 margin-bottom align-center">
                                        <img src={this.state.galleryImgLink} alt={this.state.galleryImgLink} />
                                    </div>
                                </div>
                                <div className="row gutter-width-lg single-content margin-bottom" >
                                    <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
                                        <h3 className='align-center'>Sinossi</h3>
                                        <div className="description align-center">
                                            {this.state.workInsideItem.sinossi}
                                        </div>
                                    </div>
                                </div>
                                <div className="row gutter-width-lg single-content" >
                                    <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <h3 className='align-center'>Articoli e premi</h3>

                                    </div>
                                </div>


                                <div className="row gutter-width-lg single-content">
                                    <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        {this.state.imageList && this.state.imageList.map((item, key) => {
                                            return (
                                                <div className="img object-fit">
                                                    <div className="object-fit-cover margin">
                                                        <img src={item.imgLink} alt={item.title} />
                                                    </div>
                                                </div>

                                            )
                                        })};
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>

                <Footer />
            </Fragment>
        );
    }
}


export default WorksInside;
