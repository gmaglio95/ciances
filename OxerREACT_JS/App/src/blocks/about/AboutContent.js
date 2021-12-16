import React from 'react';

const AboutContent = () => {
    return (
        <div id="about" className="block">
            <h2>
                <span className="line">A passionate</span><br /> photographer, designer in media.
            </h2>

            <div className="row bg-half-ring-left gutter-width-lg">
                <div className="col align-self-top pl-0">
                    <div className="img object-fit">
                        <div className="object-fit-cover">
                            <img src={process.env.PUBLIC_URL + "/assets/img/profilo.png"} alt="Gabriele Ciances" className="img-fluid" />
                        </div>
                    </div>
                </div>

                <div className="col align-self-center description">
                    <h4>Gabriele Ciances</h4>

                    <p>Regista e sceneggiatore, ha iniziato a lavorare come assistente alla regia su svariati set di spot web e televisivi. Ha diretto un corto, diversi spot per il web, videoclip di noti artisti della scena musicale italiana e ha collaborato con aziende e agenzie come Bianca Film, Il Fatto Quotidiano, Huawei Honor, Vodafone, Rizzoli Editore, KIKO Milano, BluKids, OVS, Alfa Romeo, STYLE Magazine, NeroGiardini.
                        Ha lavorato come assistente di Fabio Mollo, partecipando ad alcuni dei suoi progetti tra cui il film Il padre d'Italia (2017) con Luca Marinelli e Isabella Ragonese.</p>

                    <p>Nel 2018 insieme a Federico Allocca e Andrea Sestu, firma la scrittura e la co-regia del documentario #OPS - L'Evento, distribuito al cinema da Notorious Pictures.

                    </p>
                </div>
            </div>
        </div>
    );
};

export default AboutContent;
