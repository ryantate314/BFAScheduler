json.array!(@workers) do |worker|
  json.extract! worker, :id, :firstName, :lastName, :email, :phone
  json.url worker_url(worker, format: :json)
end
