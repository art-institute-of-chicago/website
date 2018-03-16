import { purgeProperties, triggerCustomEvent } from '@area17/a17-helpers';

const closeRoadblock = function(container) {

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    triggerCustomEvent(document, 'roadblock:close');
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default closeRoadblock;
