export default () => ({
  toasts: [],
  visible: [],

  add(toast) {
    toast = toast[0]

    toast = {
      id: Date.now(),
      component_id: toast.component_id,
      type: toast.options.type,
      title: toast.options.title,
      description: toast.options.description,
      method: toast.options.method,
      params: toast.options.params,
      labels: {
        accept: toast.options.acceptLabel,
        reject: toast.options.rejectLabel,
      },
    }

    this.toasts.push(toast)

    this.fire(toast.id)
  },

  fire(toastId) {
    this.visible.push(this.toasts.find(toast => toast.id === toastId));

    const timeShown = 3500 * this.visible.length;

    setTimeout(() => this.removeTimer(toastId), timeShown);
  },

  remove(toastId) {
    const toast = this.visible.find(toast => toast.id === toastId);
    const index = this.visible.indexOf(toast);

    this.visible.splice(index, 1);
  },

  renewTimer(toastId) {
    setTimeout(() => this.removeTimer(toastId), 2000)
  },

  removeTimer(toastId) {
    const toast = this.visible.find(toast => toast.id === toastId);
    const index = this.visible.indexOf(toast);

    if (toast?.hovered) {
      return;
    }

    this.visible.splice(index, 1);
  },

  executeAction(toast) {
    const component = window.Livewire.find(toast.component_id);
    const name = toast.method;
    const params = toast.params;

    Array.isArray(params)
      ? component?.call(name, ...params)
      : component?.call(name, params);
  },
});
