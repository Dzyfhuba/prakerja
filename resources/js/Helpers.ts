const formatCurrency = (amount: number): string => {
  const formatter = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0, // Adjust as needed
  });

  return formatter.format(amount);
};

const assetUrl = (path: string) => {
  return `${import.meta.env.VITE_APP_URL}${path}`
}

export {
  formatCurrency, assetUrl
}
