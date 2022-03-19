import React from 'react';

const AboutContent = () => {
    return (
        <div id="about" className="block spacer m-top-lg">
            <div id="bio"><h4>BIO</h4></div>

            <div className="row gutter-width-lg bio-margin-bottom">
                <div className="col-lg-5"></div>
                <div className="col-lg-2 align-center about-image">
                    <img src={process.env.PUBLIC_URL + "/assets/img/about-image.jpg"} alt={process.env.PUBLIC_URL + "assets/img/about-image.jpg"} />
                </div>
            </div>

            <div className="row gutter-width-lg">
                <div className="col-lg-3"></div>
                <div className="col-lg-6 align-self-center description text-align-center">

                <p>Gabriele Ciances (1993) Regista e Filmmaker</p>
                <p>Sono nato a Messina, dove ho avuto modo  di coltivare la mia passione per il cinema sin dall'adolescenza.</p>
                <p>Nel 2013 mi trasferisco a Milano per lavorare nel settore. Dopo diverse esperienze da assistente alla regia mi dedico del tutto al filmmaking realizzando videoclip musicali e spot per noti brand italiani. Dal 2019 vivo e lavoro a Roma.</p>
                <p>Nel 2018 scrivo e dirigo in co-regia il mio primo documentario #OPS - L'evento, distribuito al cinema da Notorious Pictures.</p>
                <p>Nel 2019 scrivo e dirigo il mio primo cortometraggio Teresa, distribuito da Zen Movie.</p>
                <p>Dal 2020 ad oggi lavoro a Ossi di Seppia, docuserie distribuita su RaiPlay.</p>
                <p>Nel 2020 realizzo Istantanee - L'anno del virus, documentario distribuito su RaiPlay.</p>
                <p>Nel 2021 dirigo DIA 1991 - Parlare poco Apparire mai, documentario prodotto da RaiCinema, distribuito su Rai3.</p>

                </div>
            </div>
        </div>
    );
};

export default AboutContent;
