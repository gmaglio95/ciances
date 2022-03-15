import React, { Component, Fragment } from 'react';
import MetaTags from 'react-meta-tags';
import { Redirect } from "react-router-dom";
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

    isCreditsNotVisible() {
        return (!this.state.workInsideItem.direzione || this.state.workInsideItem.direzione == "") &&
            (!this.state.workInsideItem.montaggio || this.state.workInsideItem.montaggio == "") &&
            (!this.state.workInsideItem.scrittura || this.state.workInsideItem.scrittura == "") &&
            (!this.state.workInsideItem.distribuzione || this.state.workInsideItem.distribuzione == "") &&
            (!this.state.workInsideItem.produzione || this.state.workInsideItem.produzione == "") &&
            (!this.state.workInsideItem.produzioneEsecutiva || this.state.workInsideItem.produzioneEsecutiva == "") &&
            (!this.state.workInsideItem.interpreti || this.state.workInsideItem.interpreti == "") &&
            (!this.state.workInsideItem.protagonisti || this.state.workInsideItem.protagonisti == "");
    }
    isArticoliVisible() {
        let isValid = false;
        isValid = this.state.workInsideItem.articoli && this.state.workInsideItem.articoli.length > 0
        let count = 0;
        if (isValid) {
            this.state.workInsideItem.articoli.map(item => {
                if (item && item.name != "" && item.link != "") {
                    count = count + 1;
                }
            });
            if (count == 0) {
                isValid = false;
            }
        }
        return isValid;
    }

    isPremiVisible() {
        let isValid = false;
        isValid = this.state.workInsideItem.premi && this.state.workInsideItem.premi.length > 0
        let count = 0;
        if (isValid) {
            this.state.workInsideItem.premi.map(item => {
                if (item && item != "") {
                    count = count + 1;
                }
            });
            if (count == 0) {
                isValid = false;
            }
        }
        return isValid;
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
        if (workInside && workInside[0] && gallery[0]) {
            this.setState({ workInsideItem: workInside[0], imageList: images, galleryImgLink: gallery[0].imgLink });
        } else {
            window.location.href = process.env.PUBLIC_URL + "/404";
        }
    }


    render() {
        document.body.classList.add('single');
        document.body.classList.add('single-portfolio');
        document.body.classList.add('bg-fixed');
        return (
            <Fragment>
                <MetaTags>
                    <meta charSet="UTF-8" />
                    <title>{this.state.workInsideItem.title}</title>

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

                <main id="main" className="site-main bg-half-ring-right bg-half-ring-top work-inside-main">
                    <section id="page-content">
                        <div className="wrapper">
                            <div id="single">


                                <div className="row gutter-width-lg single-content" >
                                    <div className="col-xl-6 col-lg-6 col-md-6 col-sm-6">

                                        <h3>{this.state.workInsideItem.title}</h3>
                                        <h5 className="small">
                                            {this.state.workInsideItem.subTitle}
                                        </h5>
                                        {(this.state.workInsideItem.linkSite || this.state.workInsideItem.linkTrailer) && <div className="description">
                                            <div className="margin-bottom-top">

                                                {this.state.workInsideItem.linkTrailer && this.state.workInsideItem.linkTrailer != "" && <div>
                                                    <h6 class="inline-div ">Guarda Trailer: </h6>
                                                    <a className="btn btn-link transform-scale-h border-0 p-0 inline-div filmlinks-margin-left" href={this.state.workInsideItem.linkTrailer} target={'_blank'}> {this.state.workInsideItem.title} </a>
                                                </div>}
                                                {this.state.workInsideItem.linkSite && this.state.workInsideItem.linkSite != "" && <div>
                                                    <h6 class="inline-div ">Guarda Film: </h6>
                                                    <a className="btn btn-link transform-scale-h border-0 p-0 inline-div filmlinks-margin-left" href={this.state.workInsideItem.linkSite} target={'_blank'}> {this.state.workInsideItem.title} </a>
                                                </div>}
                                            </div>

                                        </div>}
                                        {!this.isCreditsNotVisible() && <h3>Credits</h3>}
                                        {this.state.workInsideItem.direzione && this.state.workInsideItem.direzione != "" && <div className="row gutter-width-lg single-content" >
                                            <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div className="description ">
                                                    <div class="inline-div ">Diretto da : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.direzione}</h6></div>
                                                </div>
                                            </div>
                                        </div>
                                        }
                                        {this.state.workInsideItem.montaggio && this.state.workInsideItem.montaggio != "" && <div className="row gutter-width-lg single-content" >
                                            <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div className="description">
                                                    <div class="inline-div ">Montato da : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.montaggio}</h6></div>
                                                </div>
                                            </div>
                                        </div>}
                                        {this.state.workInsideItem.scrittura && this.state.workInsideItem.scrittura != "" && <div className="row gutter-width-lg single-content" >
                                            <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div className="description ">
                                                    <div class="inline-div ">Scritto da : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.scrittura}</h6></div>
                                                </div>
                                            </div>
                                        </div>}
                                        {this.state.workInsideItem.distribuzione && this.state.workInsideItem.distribuzione != "" && <div className="row gutter-width-lg single-content" >
                                            <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div className="description ">
                                                    <div class="inline-div ">Distribuito da : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.distribuzione}</h6></div>
                                                </div>
                                            </div>
                                        </div>}
                                        {this.state.workInsideItem.produzione && this.state.workInsideItem.produzione != "" &&
                                            <div className="row gutter-width-lg single-content" >
                                                <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <div className="description ">
                                                        <div class="inline-div ">Prodotto da : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.produzione}</h6></div>
                                                    </div>
                                                </div>
                                            </div>}
                                        {this.state.workInsideItem.produzioneEsecutiva && this.state.workInsideItem.produzioneEsecutiva != "" && <div className="row gutter-width-lg single-content" >
                                            <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div className="description ">
                                                    <div class="inline-div ">Produttori Esecutivi : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.produzioneEsecutiva}</h6></div>
                                                </div>
                                            </div>
                                        </div>}
                                        {this.state.workInsideItem.interpreti && this.state.workInsideItem.interpreti != "" && <div className="row gutter-width-lg single-content" >
                                            <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div className="description ">
                                                    <div class="inline-div ">Interpreti : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.interpreti}</h6></div>
                                                </div>
                                            </div>
                                        </div>}
                                        {this.state.workInsideItem.protagonisti && this.state.workInsideItem.protagonisti != "" && <div className="row gutter-width-lg single-content" >
                                            <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div className="description ">
                                                    <div class="inline-div ">Protagonisti : </div>  <div class="inline-div "> <h6>{this.state.workInsideItem.protagonisti}</h6></div>
                                                </div>
                                            </div>
                                        </div>}

                                    </div>
                                    <div className="col-xl-6 col-lg-6 col-md-6 col-sm-6 margin-bottom align-center">
                                        <img src={process.env.PUBLIC_URL + this.state.galleryImgLink} alt={process.env.PUBLIC_URL + this.state.galleryImgLink} />
                                    </div>
                                </div>
                                {this.state.workInsideItem.sinossi && this.state.workInsideItem.sinossi != "" && <div className="row gutter-width-lg single-content margin-bottom" >
                                    <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
                                        <h3 className='align-center'>Sinossi</h3>
                                        <div className="description align-center padding-right-left-15">
                                            {this.state.workInsideItem.sinossi}
                                        </div>
                                    </div>
                                </div>}
                                <div className="row gutter-width-lg single-content" >
                                    {this.isArticoliVisible() && <div className={this.isPremiVisible() ? "col-xl-6 col-lg-6 col-md-6 col-sm-6 articoli-margin-bottom " : "col-xl-12 col-lg-12 col-md-12 col-sm-12 articoli-margin-bottom "}>
                                        <h3 className='align-center'>Articoli</h3>
                                        {this.state.workInsideItem.articoli && this.state.workInsideItem.articoli.map((item) => {
                                            return (item && item.name && item.name != "" && item.link && item.link != "" && <div className="row gutter-width-lg single-content" >
                                                <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <div className="description articoli-margin-bottom align-center">
                                                        <div class="inline-div "><a className="btn btn-link transform-scale-h border-0 p-0" href={item.link} target={'_blank'}> {item.name} </a></div>
                                                    </div>
                                                </div>
                                            </div>)
                                        })}


                                    </div>}
                                    {this.isPremiVisible() && <div className={this.isArticoliVisible() ? "col-xl-6 col-lg-6 col-md-6 col-sm-6 articoli-margin-bottom " : "col-xl-12 col-lg-12 col-md-12 col-sm-12 articoli-margin-bottom "}>
                                        <h3 className='align-center'>Premi</h3>
                                        {this.state.workInsideItem.premi && this.state.workInsideItem.premi.map((item) => {
                                            return (item && item != "" && <div className="row gutter-width-lg single-content" >
                                                <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <div className="description articoli-margin-bottom align-center">
                                                        <h6>{item}</h6>
                                                    </div>
                                                </div>
                                            </div>)
                                        })}

                                    </div>}
                                </div>


                                <div className="row gutter-width-lg single-content">
                                    <div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        {this.state.imageList && this.state.imageList.map((item, key) => {
                                            return (
                                                <div className="img object-fit">
                                                    <div className="object-fit-cover margin">
                                                        <img src={process.env.PUBLIC_URL + item.imgLink} alt={process.env.PUBLIC_URL + item.title} />
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
