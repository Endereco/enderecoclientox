/**
 * Endereco SDK.
 *
 * @author Ilja Weber <ilja.weber@mobilemjo.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 * {@link https://endereco.de}
 */
function StatusIndicator(config) {

    if (!document.querySelector(config.inputSelector) ||
        !document.querySelector(config.displaySelector)
    ) {
        return null;
    }

    var $self  = this;
    this.inputElement = document.querySelector(config.inputSelector);
    this.displayElement = document.querySelector(config.displaySelector);
    this.config = config;
    this.statusIconElement = undefined;
    this.renderTimeout = undefined;
    this.defaultBorderColor = this.displayElement.style.borderColor;

    window.addEventListener('resize', function() {
        if (undefined !== $self.renderTimeout) {
            clearTimeout($self.renderTimeout)
        }
        $self.renderTimeout = setTimeout( function() {
            $self.calculatePosition();
        }, 200);
    });

    this.calculatePosition = function() {
        var position = {
            top: 0,
            left: 0
        };

        var width = window.innerWidth
            || document.documentElement.clientWidth
            || document.body.clientWidth;

        if (width > 990) {
            position.top = ($self.displayElement.offsetTop);
            position.left = ($self.displayElement.offsetLeft + $self.displayElement.offsetWidth + 4);
        } else {
            position.top = $self.displayElement.offsetTop - 30;
            position.left = $self.displayElement.offsetLeft + $self.displayElement.offsetWidth - 20;
        }

        if (undefined !== $self.statusIconElement) {
            $self.statusIconElement.style.top = position.top + 'px';
            $self.statusIconElement.style.left = position.left + 'px';
        }

        return position;
    }

    // Render success icon
    this.renderSuccess = function() {
        if (undefined !== $self.statusIconElement) {
            $self.statusIconElement.remove();
            $self.statusIconElement = undefined;
        }

        this.statusIconElement = document.createElement('span');
        this.statusIconElement.appendChild(document.createTextNode('✓'));

        this.statusIconElement.style.position = 'absolute';
        this.statusIconElement.style.color = $self.config.colors.successColor;
        this.statusIconElement.style.fontSize = '22px';

        this.calculatePosition();

        $self.displayElement.parentNode.insertBefore(this.statusIconElement, $self.displayElement.nextSibling);
    }

    // Render success icon
    this.renderCheck = function() {
        if (undefined !== $self.statusIconElement) {
            $self.statusIconElement.remove();
            $self.statusIconElement = undefined;
        }

        this.statusIconElement = document.createElement('span');
        this.statusIconElement.appendChild(document.createTextNode('⚠'));

        this.statusIconElement.style.position = 'absolute';
        this.statusIconElement.style.color = $self.config.colors.warningColor;
        this.statusIconElement.style.fontSize = '22px';

        this.calculatePosition();

        $self.displayElement.parentNode.insertBefore(this.statusIconElement, $self.displayElement.nextSibling);
    }

    // Remove status icon
    this.renderClean = function() {
        if (undefined !== $self.statusIconElement) {
            $self.statusIconElement.remove();
            $self.statusIconElement = undefined;
        }
    }

    //// Listen to events
    this.inputElement.addEventListener('endereco.valid', function() {
        $self.displayElement.style.borderColor = $self.config.colors.successColor;
        $self.renderSuccess();
    });

    this.inputElement.addEventListener('endereco.check', function() {
        $self.displayElement.style.borderColor = $self.config.colors.warningColor;
        $self.renderCheck();
    });

    this.inputElement.addEventListener('endereco.loading', function() {
        $self.displayElement.style.borderColor = $self.defaultBorderColor;
        $self.renderClean();
    });

    this.inputElement.addEventListener('endereco.clean', function() {
        $self.displayElement.style.borderColor = $self.defaultBorderColor;
        $self.renderClean();
    });
}
