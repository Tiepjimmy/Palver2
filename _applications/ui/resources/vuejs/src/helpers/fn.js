// Wait for a while
export function wait(ms) {
  return x => new Promise(resolve => setTimeout(() => resolve(x), ms));
}

/**
 * numberFormat(n, x, s, c)
 *
 * @param mixed   v: value
 * @param integer n: length of decimal
 * @param integer x: length of whole part
 * @param mixed   s: sections delimiter
 * @param mixed   c: decimal delimiter
 */
export const numberFormat = function (v, n, x, s, c) {
  var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
    num = Number(v).toFixed(Math.max(0, ~~n));

  return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};
